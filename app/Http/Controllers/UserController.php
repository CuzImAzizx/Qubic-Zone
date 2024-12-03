<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Gemini\Enums\ModelType;
use Gemini\Laravel\Facades\Gemini;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Insight {
    public $total;
    public $totalIncoming;
    public $totalOutgoing;
    public $transactionsCount;

    public function __construct($total, $totalIncoming, $totalOutgoing, $transactionsCount) {
        $this->total = $total;
        $this->totalIncoming = $totalIncoming;
        $this->totalOutgoing = $totalOutgoing;
        $this->transactionsCount = $transactionsCount;
    }
}
class UserController extends Controller
{
    public function showHomePage(){
        //Get the authentecated user
        $user = auth()->user();
        //Get all transactions for that user
        $transactions = Transaction::where('user_id', '=', $user->id)->get();
        //Get the insights of the transactions
        $insight = $this->getInsight($transactions);
        //Return the view with the insights
        return view('index')->with('insight', $insight);
    }

    public function showAddTransactionPage(){
        return view('addTransaction');
    }

    public function showAddTransactionManualPage(){
        return view('addTransactionManual');
    }

    public function analyzeTransaction(Request $request){
        //Validate the SMS Message, (optional)
        $validated = $request->validate([
            'smsMessage' => 'required|max:255',
        ]);
        
        //Pass it to the AI
        //$res = Gemini::generativeModel('models/gemini-1.5-flash')->generateContent('Hello there');
        //return $res->text(); //IT WORKS!!!

        $initPrompt = "You are part of a program designed to extract and return a JSON object from a transaction SMS message. This object must contain the following fields:
        - **name**: string
        - **amount**: float (negative for outgoing transfers or purchases, positive for incoming transfers)
        - **date**: string in YYYY-MM-DD format.
        
        Do not include the ```json``` code formatting. just the JSON object. If the input is not a valid SMS transaction or lacks any of the required fields (name, amount, or date), return the word 'false'. Ignore everything below the '**START OF SMS**' line.";
        $wholePrompt  = "$initPrompt\n**START OF SMS**\n$request->smsMessage\n**END OF SMS**";

        $AIResponseText = Gemini::generativeModel('models/gemini-1.5-flash')->generateContent($wholePrompt);
        //return $AIResponseText->text();
        if($AIResponseText->text() == "false\n" or $AIResponseText->text() == "false"){
            return redirect()->back()->withErrors([
                'smsMessage' => 'على ما يبدو ان هذي ماهي رسالة عمليّة شراء. جرب تدخّلها بشكل يدوي',
            ])->withInput();
        }
        $transaction = json_decode($AIResponseText->text());
        return view('confirmationTransaction')->with('transaction', $transaction)->with('smsMessage', $request->smsMessage);
    }

    public function insertTransaction(Request $request){
        $user = auth()->user();
        $request->validate([
            'sms_message' => 'nullable|max:255',
            'storeName' => 'required|max:255',
            'amount' => 'required|max:255',
            'date' => 'required|date_format:Y-m-d',
            'image' => 'nullable|image|max:5000',
            'note' => 'nullable|max:2500'

        ]);

        $insertedTransaction = Transaction::create([
            "user_id" => $user->id,
            "sms_message" => $request->smsMessage,
            "store_name" => $request->storeName,
            "amount" => $request->amount,
            "date" => $request->date,
            "image" => $request->image,
            "note" => $request->note,
        ]);

        //I want to redirect with the transaction
        return view('flashMessage')->with('status', 'success')->with('insertedTransaction', $insertedTransaction);
        
    }

    public function viewAllTransactions(){
        $user = auth()->user();
        $transactions = Transaction::where('user_id', '=', $user->id)->get();
        if(!$transactions){
            //
        }
        $insight = $this->getInsight($transactions);
        
        //Retrun the view with insight and transactions
        return view('allTransactions')->with('transactions', $transactions)->with('insight', $insight);
    }

    public function filterTransactions(Request $request){
        $request->validate([
            'searchTerm' => 'nullable|max:255',
            'startDate' => 'nullable|date_format:Y-m-d|before_or_equal:endDate',
            'endDate' => 'nullable|date_format:Y-m-d|after_or_equal:startDate|required_with:startDate',
            'startAmount' => 'nullable|lte:endAmount|required_with:endAmount',
            'endAmount' => 'nullable|gte:startAmount|required_with:startAmount',
        ]);
        if(is_null($request->searchTerm) and is_null($request->startDate) and is_null($request->startAmount)){
            //wtf is with the user?
            return redirect('/transactions');
        }
        $transactions = Transaction::query();

        // Search term conditions
        if (!is_null($request->searchTerm)) {
            $transactions->where(function ($query) use ($request) {
                $query->where('sms_message', 'like', "%{$request->searchTerm}%")
                      ->orWhere('note', 'like', "%{$request->searchTerm}%")
                      ->orWhere('store_name', 'like', "%{$request->searchTerm}%");
            });
        }
    
        // Date range conditions
        if (!is_null($request->startDate) && !is_null($request->endDate)) {
            $transactions->whereBetween('date', [$request->startDate, $request->endDate]);
        }

        //Amount range conditions
        if(!is_null($request->startAmount) or !is_null($request->endAmount)){
            $transactions->whereBetween('amount', [$request->startAmount, $request->endAmount]);
        }
    
        // Get results
        $transactions = $transactions->get();
    
        $insight = $this->getInsight($transactions);
        return view('allTransactions')->with('transactions', $transactions)->with('insight', $insight);

    }

    private function getInsight($transactions){
    $total = 0;
    $totalOutgoing = 0;
    $totalIncoming = 0;
    $transactionsCount = $transactions->count();
    for($i = 0; $i < $transactionsCount; $i++){
        $transaction = $transactions[$i];
        $total += $transaction->amount;
        if($transaction->amount > 0){
            $totalIncoming += $transaction->amount;
        } else {
            $totalOutgoing += $transaction->amount;
        }
    }

    $insight = new Insight($total, $totalIncoming, $totalOutgoing, $transactionsCount);
    return $insight;

    }
}
