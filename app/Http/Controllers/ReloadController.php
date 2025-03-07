<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bb;
use Illuminate\Support\Facades\Auth;


class ReloadController extends Controller
{
   // Отображение страницы с выбором подписки
   public function index()
   {
       // Получаем текущую подписку пользователя
       $currentSubscription = Bb::where('user_id', Auth::id())->first();

       return view('upgrade', compact('currentSubscription'));
   }

   // Обработка обновления подписки
   public function update(Request $request)
   {
       // Валидация данных
       $validatedData = $request->validate([
           'title' => 'required|string|max:255',
           'content' => 'required|string',
           'price' => 'required|integer|in:3,6,12', // Добавлены все возможные значения
       ]);

       // Получаем текущую подписку пользователя
       $currentSubscription = Bb::where('user_id', Auth::id())->first();

       // Если подписка существует, обновляем её
       if ($currentSubscription) {
           $currentSubscription->update([
               'title' => $validatedData['title'],
               'content' => $validatedData['content'],
               'price' => $validatedData['price'],
               'status' => 'Активно', // Устанавливаем статус "Активно"
           ]);
       } else {
           // Если подписки нет, создаем новую
           Bb::create([
               'user_id' => Auth::id(),
               'title' => $validatedData['title'],
               'content' => $validatedData['content'],
               'price' => $validatedData['price'],
               'status' => 'Активно',
           ]);
       }

       // Редирект с сообщением об успехе
       return redirect()->route('checkpoint')->with('success', 'Подписка успешно обновлена!');
   }
}
