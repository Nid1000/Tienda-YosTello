<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        $now = now();

        DB::table('users')
            ->where('role', 'admin')
            ->orderBy('id')
            ->get()
            ->each(function (object $user) use ($now): void {
                DB::table('admins')->updateOrInsert(
                    ['email' => $user->email],
                    [
                        'name' => $user->name,
                        'password' => $user->password,
                        'is_active' => true,
                        'created_at' => $user->created_at ?? $now,
                        'updated_at' => $now,
                    ]
                );

                $hasOrders = DB::table('orders')->where('user_id', $user->id)->exists();

                if ($hasOrders) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'email' => 'migrated-admin-'.$user->id.'-'.$user->email,
                            'password' => Hash::make(str()->random(48)),
                            'role' => 'customer',
                            'updated_at' => $now,
                        ]);

                    return;
                }

                DB::table('users')->where('id', $user->id)->delete();
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
