<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class PasswordResetController extends Controller
{
    public function requestForm()
    {
        return view('auth/request_password');
    }

    public function sendResetLink()
    {
        $email = $this->request->getPost('email');
        // Validar que el email exista en la base de datos
        $userModel = new UsuariosModel();
        $user = $userModel->where('correo', $email)->first();
        
        if (!$user) {
            return redirect()->back()->with('error', 'El correo electrónico no está registrado.');
        }

        // Generar token y guardarlo en la tabla password_resets
        $token = bin2hex(random_bytes(50));
        $expires_at = new \DateTime();  // Crear una fecha con la clase nativa de PHP
        $expires_at->modify('+1 hour'); // Sumarle 1 hora
        $formattedDate = $expires_at->format('Y-m-d H:i:s');
        
        //$expires_at = Time::now()->addHours(1);
        // Guardar token
        

        $db = \Config\Database::connect();
        $builder = $db->table('mbi_password_resets');
        $builder->where('email', $email)->delete(); // Limpia tokens anteriores
        $builder->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => $formattedDate,
        ]);

        // Enviar enlace al correo
        $resetLink = site_url("password/reset/$token");
        $message = "Haga clic en este enlace para restablecer su contraseña: $resetLink";

        $email = 'reyesabdias@gmail.com';
        $email_service = \Config\Services::email();
        $email_service->setFrom('ventas@sellopronto.com.mx','Sello Pronto');
        $email_service->setTo($email);
        $email_service->setSubject('Cusrsos');
        $email_service->setMessage($message);
        $email_service->send();

        return redirect()->back()->with('message', 'Enlace de recuperación enviado al correo.');
    }

    public function showResetForm($token)
    {
        return view('auth/reset_password', ['token' => $token]);
    }

    public function resetPassword()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $password_confirm = $this->request->getPost('password_confirm');

        // Verificar que las contraseñas coincidan
        if ($password !== $password_confirm) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
        }

        // Verificar que el token sea válido
        $db = \Config\Database::connect();
        $builder = $db->table('mbi_password_resets');
        $resetData = $builder->where('token', $token)->get()->getRow();

        if (!$resetData || Time::now()->isAfter($resetData->created_at)) {
            return redirect()->back()->with('error', 'El enlace de recuperación es inválido o ha expirado.');
        }

        // Actualizar la contraseña del usuario
        $userModel = new UsuariosModel();
        $userModel->where('correo', $resetData->email)
                  ->set('password', password_hash($password, PASSWORD_DEFAULT))
                  ->update();

        // Eliminar el token de la tabla password_resets
        $builder->where('email', $resetData->email)->delete();

        return redirect()->to('/')->with('message', 'Contraseña actualizada con éxito.');
    }
}
