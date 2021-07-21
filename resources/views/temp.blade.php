@foreach($gifts as $gift)

    DB::table('gifts')->insert([
<br>
        'id' => {{ $gift->id }},
<br>
        'name' => '{{ $gift->nombre }}',
<br>
        'date' => '{{ $gift->date }}',
<br>
        'exception' => '{{ $gift->exception }}',
<br>
        'created_at' => now(),
<br>
        'updated_at' => now()
<br>
    ]);

<br>
<br>




@endforeach
