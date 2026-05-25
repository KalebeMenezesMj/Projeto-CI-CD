<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $rosas = Category::where('slug', 'rosas')->first();
        $buques = Category::where('slug', 'buques')->first();
        $arranjos = Category::where('slug', 'arranjos')->first();
        $plantas = Category::where('slug', 'plantas')->first();
        $cestas = Category::where('slug', 'cestas')->first();
        $tropicais = Category::where('slug', 'flores-tropicais')->first();

        $products = [
            // Rosas
            ['category_id' => $rosas->id, 'name' => 'Rosa Vermelha - Dúzia', 'slug' => 'rosa-vermelha-duzia', 'description' => 'Dúzia de rosas vermelhas frescas, símbolo clássico do amor e paixão. Embrulhadas com papel especial e laço de cetim.', 'price' => 89.90, 'promotional_price' => 79.90, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=400', 'featured' => true, 'active' => true],
            ['category_id' => $rosas->id, 'name' => 'Rosa Branca - Dúzia', 'slug' => 'rosa-branca-duzia', 'description' => 'Dúzia de rosas brancas, símbolo de pureza e elegância. Perfeita para casamentos e momentos especiais.', 'price' => 89.90, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=400', 'featured' => false, 'active' => true],
            ['category_id' => $rosas->id, 'name' => 'Rosa Rosa - Dúzia', 'slug' => 'rosa-rosa-duzia', 'description' => 'Dúzia de rosas cor-de-rosa delicadas e românticas. Ideais para demonstrar carinho e afeto.', 'price' => 85.00, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1561181286-d3fee7d55364?w=400', 'featured' => false, 'active' => true],
            ['category_id' => $rosas->id, 'name' => 'Rosas Coloridas - Dúzia Mista', 'slug' => 'rosas-coloridas-duzia-mista', 'description' => 'Dúzia de rosas em variadas cores: vermelhas, rosas, brancas e amarelas. Uma explosão de alegria!', 'price' => 95.00, 'promotional_price' => 85.00, 'stock' => 25, 'image' => 'https://images.unsplash.com/photo-1496062031456-07b8f162a322?w=400', 'featured' => true, 'active' => true],
            ['category_id' => $rosas->id, 'name' => 'Rosa Amarela - Dúzia', 'slug' => 'rosa-amarela-duzia', 'description' => 'Dúzia de rosas amarelas, símbolo de amizade e alegria. Traga mais sol ao dia de alguém especial.', 'price' => 85.00, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1587314168485-3236d6710814?w=400', 'featured' => false, 'active' => true],

            // Buquês
            ['category_id' => $buques->id, 'name' => 'Buquê Romântico', 'slug' => 'buque-romantico', 'description' => 'Buquê especialmente montado com rosas vermelhas, gérberas e folhagens. Ideal para declarações de amor.', 'price' => 120.00, 'promotional_price' => 99.90, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1487530811015-780f5c6d3c5d?w=400', 'featured' => true, 'active' => true],
            ['category_id' => $buques->id, 'name' => 'Buquê Primavera', 'slug' => 'buque-primavera', 'description' => 'Um colorido buquê com flores da estação: girassóis, margaridas e flores silvestres.', 'price' => 110.00, 'stock' => 15, 'image' => 'https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=400', 'featured' => true, 'active' => true],
            ['category_id' => $buques->id, 'name' => 'Buquê Noiva Clássico', 'slug' => 'buque-noiva-classico', 'description' => 'Buquê clássico para noivas com rosas brancas, lírios e folhagens elegantes.', 'price' => 250.00, 'stock' => 10, 'image' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400', 'featured' => false, 'active' => true],
            ['category_id' => $buques->id, 'name' => 'Buquê Tropical', 'slug' => 'buque-tropical', 'description' => 'Buquê vibrante com flores tropicais: heliconias, bromélias e folhagens exóticas.', 'price' => 145.00, 'stock' => 12, 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400', 'featured' => false, 'active' => true],

            // Arranjos
            ['category_id' => $arranjos->id, 'name' => 'Arranjo Mesa Elegante', 'slug' => 'arranjo-mesa-elegante', 'description' => 'Arranjo floral de mesa com rosas, lírios e folhagens em vaso de vidro. Elegância para sua decoração.', 'price' => 185.00, 'promotional_price' => 165.00, 'stock' => 8, 'image' => 'https://images.unsplash.com/photo-1567696153798-9111f9cd3d0d?w=400', 'featured' => true, 'active' => true],
            ['category_id' => $arranjos->id, 'name' => 'Arranjo Condolências', 'slug' => 'arranjo-condolencias', 'description' => 'Arranjo floral branco e delicado para momentos de pesar. Com lírios, rosas brancas e folhagens.', 'price' => 200.00, 'stock' => 5, 'image' => 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=400', 'featured' => false, 'active' => true],
            ['category_id' => $arranjos->id, 'name' => 'Arranjo Centro de Mesa', 'slug' => 'arranjo-centro-mesa', 'description' => 'Lindo arranjo para centro de mesa com mistura de flores coloridas e folhagens decorativas.', 'price' => 160.00, 'stock' => 10, 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400', 'featured' => false, 'active' => true],

            // Plantas
            ['category_id' => $plantas->id, 'name' => 'Orquídea Phalaenopsis', 'slug' => 'orquidea-phalaenopsis', 'description' => 'Linda orquídea Phalaenopsis em vaso decorativo. Duração de até 3 meses com cuidados simples.', 'price' => 135.00, 'promotional_price' => 119.90, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1566225556563-48c9bd8e1abb?w=400', 'featured' => true, 'active' => true],
            ['category_id' => $plantas->id, 'name' => 'Suculentas Kit', 'slug' => 'suculentas-kit', 'description' => 'Kit com 6 suculentas variadas em vasinhos individuais. Fáceis de cuidar e muito decorativas.', 'price' => 65.00, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=400', 'featured' => false, 'active' => true],
            ['category_id' => $plantas->id, 'name' => 'Bromelia Vermelha', 'slug' => 'bromelia-vermelha', 'description' => 'Bromelia de flores vermelhas vivas em vaso de cerâmica. Resistente e de longa duração.', 'price' => 89.90, 'stock' => 15, 'image' => 'https://images.unsplash.com/photo-1455793781789-a4a4e9e0d3d2?w=400', 'featured' => false, 'active' => true],
            ['category_id' => $plantas->id, 'name' => 'Cacto Decorativo', 'slug' => 'cacto-decorativo', 'description' => 'Cacto em vaso de concreto decorativo. Ideal para quem não tem muito tempo para cuidar de plantas.', 'price' => 45.00, 'stock' => 25, 'image' => 'https://images.unsplash.com/photo-1459156212016-c812468e2115?w=400', 'featured' => false, 'active' => true],

            // Cestas
            ['category_id' => $cestas->id, 'name' => 'Cesta Flores & Chocolates', 'slug' => 'cesta-flores-chocolates', 'description' => 'Cesta romântica com buquê de rosas, caixa de chocolates Ferrero e cartão personalizado.', 'price' => 220.00, 'promotional_price' => 199.90, 'stock' => 15, 'image' => 'https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=400', 'featured' => true, 'active' => true],
            ['category_id' => $cestas->id, 'name' => 'Cesta Aniversário Especial', 'slug' => 'cesta-aniversario-especial', 'description' => 'Cesta de aniversário com flores coloridas, pelúcia, balão e mensagem personalizada.', 'price' => 280.00, 'stock' => 8, 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400', 'featured' => false, 'active' => true],
            ['category_id' => $cestas->id, 'name' => 'Cesta Mãe Querida', 'slug' => 'cesta-mae-querida', 'description' => 'Cesta especial para o Dia das Mães com flores, perfume e chocolates. Surpreenda quem você ama!', 'price' => 350.00, 'promotional_price' => 299.90, 'stock' => 10, 'image' => 'https://images.unsplash.com/photo-1487530811015-780f5c6d3c5d?w=400', 'featured' => true, 'active' => true],

            // Flores Tropicais
            ['category_id' => $tropicais->id, 'name' => 'Heliconia Tropical', 'slug' => 'heliconia-tropical', 'description' => 'Exuberantes heliconias tropicais em arranjo especial. Cores vibrantes que encantam qualquer ambiente.', 'price' => 130.00, 'stock' => 12, 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400', 'featured' => false, 'active' => true],
            ['category_id' => $tropicais->id, 'name' => 'Strelitzia - Ave do Paraíso', 'slug' => 'strelitzia-ave-do-paraiso', 'description' => 'A exótica Ave do Paraíso em toda sua majestade. Uma flor única que impressiona pela originalidade.', 'price' => 155.00, 'promotional_price' => 139.90, 'stock' => 8, 'image' => 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=400', 'featured' => true, 'active' => true],
            ['category_id' => $tropicais->id, 'name' => 'Antúrio Vermelho', 'slug' => 'anthurium-vermelho', 'description' => 'Antúrios vermelhos brilhantes em arranjo moderno. Elegância tropical para qualquer ocasião.', 'price' => 99.90, 'stock' => 18, 'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=400', 'featured' => false, 'active' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
