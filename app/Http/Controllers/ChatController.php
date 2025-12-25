<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Message;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{

    public function showChat($receiver_id)
    {
        $messages = Message::where('sender_id', Auth::guard('patient')->user()->pid)
            ->where('receiver_id', $receiver_id)
            ->orWhere('sender_id', $receiver_id)
            ->where('receiver_id', Auth::guard('patient')->user()->pid)
            ->get();

        $sender = Doctor::findOrFail($receiver_id);


        return view('client.chatscreen.chat', compact('receiver_id', 'messages', 'sender'));
    }

    public function showChatDoctor($patientId)
    {
        $doctorId = Auth::guard('doctor')->user()->docid;

        $messages = Message::where(function ($q) use ($doctorId, $patientId) {
            $q->where('sender_id', $doctorId)
                ->where('receiver_id', $patientId)
                ->where('sender_type', 'doctor');
        })
            ->orWhere(function ($q) use ($doctorId, $patientId) {
                $q->where('sender_id', $patientId)
                    ->where('receiver_id', $doctorId)
                    ->where('sender_type', 'patient');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $sender = Patient::findOrFail($patientId);

        return view('doctor.chatscreen.chat', compact('patientId', 'messages', 'sender'));
    }


    public function update(Request $request, Message $message)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // Identify logged-in user (patient or doctor)
        if (Auth::guard('patient')->check()) {
            $userId = Auth::guard('patient')->user()->pid;
            $userType = 'patient';
        } elseif (Auth::guard('doctor')->check()) {
            $userId = Auth::guard('doctor')->user()->docid;
            $userType = 'doctor';
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Authorization: only sender can edit
        if ($message->sender_id !== $userId || $message->sender_type !== $userType) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $message->update([
            'message' => $request->message
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->message
        ]);
    }

    // Reusable delete method
    public function destroy(Message $message)
    {
        // Identify logged-in user
        if (Auth::guard('patient')->check()) {
            $userId = Auth::guard('patient')->user()->pid;
            $userType = 'patient';
        } elseif (Auth::guard('doctor')->check()) {
            $userId = Auth::guard('doctor')->user()->docid;
            $userType = 'doctor';
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Authorization: only sender can delete
        if ($message->sender_id !== $userId || $message->sender_type !== $userType) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully'
        ]);
    }


    public function sendMessage(Request $request)
    {
        $message = new Message();

        if (Auth::guard('patient')->check()) {
            $message->sender_id = Auth::guard('patient')->user()->pid;
            $message->sender_type = 'patient';

            $message->receiver_type = 'doctor';
        } else {
            $message->sender_id = Auth::guard('doctor')->user()->docid;
            $message->sender_type = 'doctor';

            $message->receiver_type = 'patient';
        }

        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->save();

        return response()->json(['message' => 'Message sent']);
    }
    public function getMessages($receiver_id)
    {
        if (Auth::guard('patient')->check()) {
            $currentId = Auth::guard('patient')->user()->pid;
        } else {
            $currentId = Auth::guard('doctor')->user()->docid;
        }

        $messages = Message::where(function ($q) use ($currentId, $receiver_id) {
            $q->where('sender_id', $currentId)
                ->where('receiver_id', $receiver_id);
        })
            ->orWhere(function ($q) use ($currentId, $receiver_id) {
                $q->where('sender_id', $receiver_id)
                    ->where('receiver_id', $currentId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function showNotification()
    {
        $patient = Auth::guard('patient')->user();
        $patientId = auth()->guard('patient')->user()->pid;
        $appointments = Appointment::where('pid', $patientId)
            ->whereIn('status', ['cancelled', 'finished', 'pending'])
            ->orderBy('created_at', 'desc')
            ->with('schedule.mydoctor')
            ->get();

        foreach ($appointments as $appointment) {
            $appointment->time_left = \Carbon\Carbon::parse($appointment->appodate)->diffForHumans();
        }

        return view('client.chatscreen.notif', compact('appointments'));
    }

    public function showDoctorMessages()
    {
        $doctorId = Auth::guard('doctor')->user()->docid;

        $messages = Message::where('receiver_id', $doctorId)
            ->where('sender_type', 'patient')
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('doctor.chatscreen.messages', compact('messages'));
    }

    public function showMessage()
    {
        $patientId = Auth::guard('patient')->user()->pid;
        $messages = Message::where('receiver_id', $patientId)
            ->where('sender_type', 'doctor')
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.chatscreen.messages', compact('messages'));
    }

    public function markAsRead(Message $message)
    {
        if (!Auth::guard('patient')->check()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $patientId = Auth::guard('patient')->user()->pid;
        if ((int) $message->receiver_id !== (int) $patientId || $message->receiver_type !== 'patient') {
            abort(Response::HTTP_FORBIDDEN);
        }

        if (!$message->read) {
            $message->read = true;
            $message->save();
        }

        return back();
    }

    public function markAsReadDoctor(Message $message)
    {
        if (!Auth::guard('doctor')->check()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $doctorId = Auth::guard('doctor')->user()->docid;
        if ((int) $message->receiver_id !== (int) $doctorId || $message->receiver_type !== 'doctor') {
            abort(Response::HTTP_FORBIDDEN);
        }

        if (!$message->read) {
            $message->read = true;
            $message->save();
        }

        return back();
    }
}
