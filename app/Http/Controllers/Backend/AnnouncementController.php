<?php

namespace App\Http\Controllers\Backend;

use App\Announcement;
use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use Yajra\Datatables\Datatables;
use App\RecipientAnnouncement;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Session;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $announcement = DB::table('announcements AS a')
                            ->leftJoin('users AS b', 'a.sender_id','=','b.id')
                            ->select('a.*','b.*')
                            ->get();

            return Datatables::of($announcement)
                ->addIndexColumn()
                ->addColumn('action', function ($announcement) {
                    return view('partials._action', [
                        'model'           => $announcement,
                        'form_url'        => route('announcement.destroy', $announcement->id),
                        'edit_url'        => route('announcement.edit', $announcement->id)
                    ]);
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('backend.announcement.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = User::select('role')->groupBy('role')->get();
        
        return view('backend.announcement.create',compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'members' => 'required',
            'subject' => 'required|max:225',
            'content' => 'required',
        ]);

        
        DB::transaction(function () use($request) {
            $emails = User::where('role', $request->members)->pluck('email');           

            $alt_announcement = new Announcement;
            $alt_announcement->subject = $request->subject;
            $alt_announcement->content = $request->content;
            $alt_announcement->recipient_role = (json_encode($emails));
            $alt_announcement->sender_id = Auth::user()->id;
            $alt_announcement->save();

            // $alt_recipient_announcement = new RecipientAnnouncement;
            // $alt_recipient_announcement->announcement_id = $alt_announcement->id;
            // $alt_recipient_announcement->recipient_id = $request->recipient_id;
            // $alt_recipient_announcement->save();

            
            $emails = User::where('role', $request->members)->get();

            $details = [
                'title' => $request->input('subject'),
                'body' => $request->input('content'),
            ];

            $subject = $request->input('subject');

            foreach ($emails as $value) {
                Mail::to($value->email)->send(new SendEmail($details, $subject));
            }

        });        

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Email berhasil dikirim"
        ]);

        return redirect()->route('announcement.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $announcement = Announcement::find($id);

        if ($announcement > 0) {
            $announcement->delete();

            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil menghapus data"
            ]);

            return redirect()->route('announcement.index');
            
        }
            Session::flash("flash_notification", [
                "level" => "warning",
                "message" => "Tidak dapat menghapus Announcement ini, ID tidak ditemukan."
            ]);
            return redirect()->back();

        
    }
}
