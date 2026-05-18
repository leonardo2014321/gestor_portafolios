<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesionUsuario extends Model
{
    protected $table = 'sesiones_usuario';

    protected $fillable = [
        'usuario_id',
        'token',
        'ip_address',
        'user_agent',
        'expiracion',
        'last_seen_at',
    ];

    protected $casts = [
        'expiracion'   => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    // Desactivar timestamps automáticos de Laravel (la tabla tiene solo created_at)
    const UPDATED_AT = null;

    // ── Relación con Usuario ──
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // ── ¿Está este usuario en línea? (activo en los últimos 5 minutos) ──
    public static function estaEnLinea(int $usuarioId): bool
    {
        return self::where('usuario_id', $usuarioId)
            ->where('last_seen_at', '>=', now()->subMinutes(5))
            ->where('expiracion', '>=', now())
            ->exists();
    }

    // ── Limpiar sesiones expiradas de un usuario ──
    public static function limpiarExpiradas(int $usuarioId): void
    {
        self::where('usuario_id', $usuarioId)
            ->where('expiracion', '<', now())
            ->delete();
    }
}