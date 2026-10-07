<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettleStudentRequest;
use App\Http\Requests\CreateStudentRequest;
use App\Models\Room;
use App\Models\Student;

class StudentsController extends Controller
{
    public function index()
    {
        $students = Student::with('room')->get();

        return response()->json($students,200);
    }

    public function store(CreateStudentRequest $request)
    {
        $reqData = $request->validated();
        $student = Student::create($reqData);

        return response()->json([
            'message'=>'Запись успешно создана',
        ],201);
    }
    public function update(SettleStudentRequest $request, $id)// Route Model Binding (Маршрутная привязка моделей) 
    //с помощью типизации (указания класса перед переменной)  принимаем сразу ОБЪЕКТ модели Student.  
    // $student — это уже готовый объект из базы данных. 
    // НЕ НУЖНО писать Student::findOrFail(). 
    {
        $student = Student::findOrFail($id);
        $roomId = $request->validated()['room_id'];//полуичаю проверенный room id
        $room = Room::findOrFail($roomId);//findOrFail в Laravel — это  инструмент из Eloquent для поиска модели по первичному ключу. Его ключевая особенность в том, что он автоматически выбрасывает исключение, если запись с указанным ID не найдена. Это избавляет от необходимости вручную писать проверки и возвращать ошибку 404
        $currentPeopleLiving = $room->students()->count();
        $roomCapacity =$room->capacity;

        if($roomCapacity<=$currentPeopleLiving)
            return response()->json(['error'=>'В этой комнате больше нет свободных мест'],422);
        else{
            // $student->room_id = $roomId;
            // $isSaved = $student->save();
        //     if (!$isSaved) {
        //     return response()->json(['error' => 'Не удалось обновить данные'], 500);
        // }
            $student->update(['room_id'=>$roomId]);// хз каким методом лучше присвоить ему комнату
        }
        // $student->refresh();
    return response()->json($student->load('room'),200);
    }
}
