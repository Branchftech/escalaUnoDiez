<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Services\AlertService;
use App\Services\LoggerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Profile extends Component
{

    use LivewireAlert;

    public $name;
    public $email;
    public $current_password;
    public $password;
    public $password_confirmation;



    protected AlertService $alertService;
    protected LoggerService $loggerService;



    public function __construct()
    {
        $this->alertService = app(AlertService::class);
        $this->loggerService = app(LoggerService::class);

    }

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }


    public function render()
    {
        return view('livewire.auth.profile');
    }

    public function updateProfileInformation()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::where('email', $this->email)->first();

        if ($user && $user->id != auth()->user()->id) {
            $this->alertService->error($this, 'El email ya está en uso');
            return;
        }

        try {
            auth()->user()->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            $this->alertService->success($this, 'Perfil actualizado con éxito');
             return redirect()->to('/profile');
        } catch (\Throwable $th) {
            $this->alertService->error($this, 'Error al actualizar el perfil');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function updateProfilePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);


        if (!Hash::check($this->current_password, auth()->user()->password)) {
            $this->alertService->error($this, 'La contraseña actual no coincide');

            $this->reset('current_password', 'password', 'password_confirmation');
            return;
        }

        if ($this->current_password == $this->password) {
            $this->alertService->error($this, 'La nueva contraseña no puede ser igual a la actual');

            $this->reset('current_password', 'password', 'password_confirmation');
            return;
        }

        if ($this->password != $this->password_confirmation) {
            $this->alertService->error($this, 'Las contraseñas no coinciden');

            $this->reset('current_password', 'password', 'password_confirmation');
            return;
        }

        try {
            auth()->user()->update([
                'password' => Hash::make($this->password),
            ]);

            $this->reset('current_password', 'password', 'password_confirmation');

            $usuario = User::where('email', auth()->user()->email)->first();

            if ($usuario) {
                $sessions = DB::table('sessions')->where('user_id', $usuario->id)->get();
                foreach ($sessions as $session) {
                    DB::table('sessions')->where('id', $session->id)->delete();
                }
            }

            $this->alertService->success($this, 'Contraseña actualizada con éxito');
             return redirect()->to('/profile');

        } catch (\Throwable $th) {
            $this->alertService->error($this, 'Error al actualizar la contraseña');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    
}
