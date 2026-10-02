<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart_item;
use App\Models\User;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();//получил текущего пользавателя. $request->user(), Laravel возвращает тебе объект модели User — того самого пользователя, чей токен пришел в запросе.
        //все эл корзины//У модели Cart_item есть связь product(). Используем with('product'), чтобы Laravel автоматически подтянул данные о товаре для каждого элемента корзины.
        $data = $user->cart_items()->with('product')->get();

        return response()->json($data);
    }

   public function store(Request $request)
{
    // 1. Получаем текущего авторизованного пользователя
    $user = $request->user();

    // 2. Валидация данных, которые пришли с фронтенда
    $validated = $request->validate([
        'product_id' => ['required', 'exists:products,id'], // Товар должен существовать в таблице products
        'items_quantity'   => ['required', 'integer', 'min:1'],   // Количество должно быть числом и не меньше 1
    ]);

    // 3. Находим сам товар в базе, чтобы проверить остаток на складе
    $product = Product::find($validated['product_id']);

    // 4. Проверка: хватает ли товара на складе
    if ($product->in_stock < $validated['items_quantity']) {
        return response()->json([
            'error' => 'Недостаточно товара на складе'
        ], 400);
    }

    // 5. Ищем, есть ли уже этот товар в корзине у этого пользователя
    $cartItem = $user->cart_items()->where('product_id', $validated['product_id'])->first();

    // 6. Ветвление: если товар уже есть в корзине
    if ($cartItem) {
        // Увеличиваем количество (items_quantity) на величину из запроса
        $cartItem->increment('items_quantity', $validated['items_quantity']);
    } 
    // 7. Ветвление: если товара еще нет в корзине
    else {
        // Создаем новую запись в корзине для этого пользователя
        $user->cart_items()->create([
            'product_id'     => $validated['product_id'],
            'items_quantity' => $validated['items_quantity'],
        ]);
    }

    // 8. Возвращаем успешный ответ
    return response()->json([
        'message' => 'Товар успешно добавлен в корзину'
    ], 200);
}
}