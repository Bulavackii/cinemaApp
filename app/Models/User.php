<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Атрибуты, которые могут быть массово назначены.
     * Эти поля могут быть заполнены при создании или обновлении пользователя.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',        // Имя пользователя
        'email',       // Email пользователя
        'password',    // Пароль пользователя
        'role',        // Роль пользователя (admin, guest и т.д.)
    ];

    /**
     * Атрибуты, которые должны быть скрыты для сериализации.
     * Эти поля не будут отображаться при выводе данных пользователя.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',          // Скрываем пароль
        'remember_token',    // Токен для "Запомнить меня"
    ];

    /**
     * Атрибуты, которые должны быть приведены к типам.
     * Преобразование данных при работе с базой данных.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',  // Поле с датой подтверждения email
        'password' => 'hashed',             // Хеширование пароля
    ];

    /**
     * Проверка, является ли пользователь администратором.
     * 
     * @return bool
     */
    public function isAdmin()
    {
        // Проверяем, имеет ли пользователь роль 'admin'
        return $this->role === 'admin';
    }

    /**
     * Проверка, является ли пользователь гостем.
     * 
     * @return bool
     */
    public function isGuest()
    {
        // Проверяем, имеет ли пользователь роль 'guest'
        return $this->role === 'guest';
    }

    /**
     * Связь с билетами.
     * Пользователь может иметь множество билетов.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        // Связь "один ко многим" — пользователь может иметь множество билетов
        return $this->hasMany(Ticket::class);
    }
}
