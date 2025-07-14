<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Eco;
use Carbon\Carbon;

class TestRanking extends Command
{
    protected $signature = 'test:ranking';

    protected $description = 'Reseta datas dos posts e ecos para testar ranking de hoje, semana e mês';

    public function handle()
    {
        $this->info('Iniciando reset e simulação de datas para ranking...');

        $today = Carbon::now();
        $yesterday = $today->copy()->subDay();
        $weekAgo = $today->copy()->subDays(7);
        $monthAgo = $today->copy()->subDays(30);

        // Atualiza posts para ontem (pode ajustar se quiser)
        Post::query()->update([
            'created_at' => $yesterday,
            'updated_at' => $yesterday,
        ]);
        $this->info('Posts atualizados para data de ontem.');

        // Atualiza todos os ecos para ontem (exemplo)
        Eco::query()->update([
            'created_at' => $yesterday,
            'updated_at' => $yesterday,
        ]);
        $this->info('Ecos atualizados para data de ontem.');

        // Cria ecos "de hoje"
        Eco::factory()->count(5)->create([
            'created_at' => $today,
            'updated_at' => $today,
        ]);
        $this->info('Ecos de hoje criados.');

        // Cria ecos "de 7 dias atrás"
        Eco::factory()->count(5)->create([
            'created_at' => $weekAgo,
            'updated_at' => $weekAgo,
        ]);
        $this->info('Ecos de 7 dias atrás criados.');

        // Cria ecos "de 30 dias atrás"
        Eco::factory()->count(5)->create([
            'created_at' => $monthAgo,
            'updated_at' => $monthAgo,
        ]);
        $this->info('Ecos de 30 dias atrás criados.');

        $this->info('Simulação concluída. Agora você pode testar seus rankings.');
    }
}
