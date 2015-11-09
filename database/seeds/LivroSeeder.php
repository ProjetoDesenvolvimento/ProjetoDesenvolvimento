// /database/migrations/seeds/ProjectsTableSeeder.php
<?php

use Illuminate\Database\Seeder;

class TableSeeder extends Seeder {

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('livro')->delete();

        $livros = array(
            ['codigo' => 1, 'isbn' => '812030943X', 'titulo' => '1 - DESIGN THINKING', 'descricao' => 'Este livro procura introduzir a ideia de &#39;Design Thinking&#39;, um processo colaborativo que tenta utilizar a sensibilidade e a técnica criativa para suprir as necessidades das pessoas não só com o que é tecnicamente visível, mas com uma ...',  'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['codigo' => 2, 'isbn' => '212030943X', 'titulo' => '2 - DESIGN THINKING', 'descricao' => 'Este livro procura introduzir a ideia de &#39;Design Thinking&#39;, um processo colaborativo que tenta utilizar a sensibilidade e a técnica criativa para suprir as necessidades das pessoas não só com o que é tecnicamente visível, mas com uma ...',  'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['codigo' => 3, 'isbn' => '412030943X', 'titulo' => '3 - DESIGN THINKING', 'descricao' => 'Este livro procura introduzir a ideia de &#39;Design Thinking&#39;, um processo colaborativo que tenta utilizar a sensibilidade e a técnica criativa para suprir as necessidades das pessoas não só com o que é tecnicamente visível, mas com uma ...',  'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['codigo' => 4, 'isbn' => '512030943X', 'titulo' => '4 - DESIGN THINKING', 'descricao' => 'Este livro procura introduzir a ideia de &#39;Design Thinking&#39;, um processo colaborativo que tenta utilizar a sensibilidade e a técnica criativa para suprir as necessidades das pessoas não só com o que é tecnicamente visível, mas com uma ...',  'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['codigo' => 5, 'isbn' => '612030943X', 'titulo' => '5 - DESIGN THINKING', 'descricao' => 'Este livro procura introduzir a ideia de &#39;Design Thinking&#39;, um processo colaborativo que tenta utilizar a sensibilidade e a técnica criativa para suprir as necessidades das pessoas não só com o que é tecnicamente visível, mas com uma ...',  'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['codigo' => 6, 'isbn' => '712030943X', 'titulo' => '6 - DESIGN THINKING', 'descricao' => 'Este livro procura introduzir a ideia de &#39;Design Thinking&#39;, um processo colaborativo que tenta utilizar a sensibilidade e a técnica criativa para suprir as necessidades das pessoas não só com o que é tecnicamente visível, mas com uma ...',  'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['codigo' => 7, 'isbn' => '912030943X', 'titulo' => '7 - DESIGN THINKING', 'descricao' => 'Este livro procura introduzir a ideia de &#39;Design Thinking&#39;, um processo colaborativo que tenta utilizar a sensibilidade e a técnica criativa para suprir as necessidades das pessoas não só com o que é tecnicamente visível, mas com uma ...',  'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['codigo' => 8, 'isbn' => '012030943X', 'titulo' => '8 - DESIGN THINKING', 'descricao' => 'Este livro procura introduzir a ideia de &#39;Design Thinking&#39;, um processo colaborativo que tenta utilizar a sensibilidade e a técnica criativa para suprir as necessidades das pessoas não só com o que é tecnicamente visível, mas com uma ...',  'created_at' => new DateTime, 'updated_at' => new DateTime],

        );

        // Uncomment the below to run the seeder
        DB::table('livro')->insert($livros);
    }

}
