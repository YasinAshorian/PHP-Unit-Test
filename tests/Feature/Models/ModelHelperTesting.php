<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait ModelHelperTesting
{
    /** @test */
    public function InsertData()
    {
        $model = $this->model();
        $table = $this->model()->getTable();
        $data = $model::factory()->make()->toArray();
        if($model instanceof User) $data['password'] = 123456;
        $model::create($data);

        $this->assertDatabaseHas($table, $data);
    }

    abstract protected function model(): Model;
}
