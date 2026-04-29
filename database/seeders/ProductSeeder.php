<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wanita    = Category::where('slug', 'wanita')->first();
        $pria      = Category::where('slug', 'pria')->first();
        $aksesoris = Category::where('slug', 'aksesoris')->first();

        $products = [
            // WANITA
            [
                'category_id' => $wanita->id,
                'name'        => 'Linen Draped Midi Dress',
                'description' => 'Gaun midi dari bahan linen premium dengan siluet draped yang mengalir. Cocok untuk acara formal maupun kasual. Tersedia dalam warna krem dan hitam.',
                'price'       => 875000,
                'stock'       => 24,
            ],
            [
                'category_id' => $wanita->id,
                'name'        => 'Wide-Leg Crepe Trousers',
                'description' => 'Celana panjang wide-leg berbahan crepe ringan dengan potongan tinggi. Memberikan tampilan elegan dan modern untuk segala kesempatan.',
                'price'       => 650000,
                'stock'       => 30,
            ],
            [
                'category_id' => $wanita->id,
                'name'        => 'Oversized Blazer Wool',
                'description' => 'Blazer oversized dari campuran wool berkualitas tinggi. Potongan boxy yang timeless, cocok dipadukan dengan celana maupun rok.',
                'price'       => 1250000,
                'stock'       => 15,
            ],
            [
                'category_id' => $wanita->id,
                'name'        => 'Slip Satin Skirt',
                'description' => 'Rok slip berbahan satin sutra sintetis dengan tekstur halus dan kilap lembut. Siluet bias cut yang memeluk tubuh dengan anggun.',
                'price'       => 545000,
                'stock'       => 20,
            ],
            [
                'category_id' => $wanita->id,
                'name'        => 'Cropped Knit Cardigan',
                'description' => 'Kardigan rajut cropped dengan bukaan depan. Bahan cotton-blend yang lembut dan breathable, cocok untuk iklim tropis.',
                'price'       => 485000,
                'stock'       => 35,
            ],

            // PRIA
            [
                'category_id' => $pria->id,
                'name'        => 'Relaxed Linen Shirt',
                'description' => 'Kemeja linen dengan potongan relaxed fit. Kerah club collar dengan kancing tersembunyi untuk tampilan minimalis yang clean.',
                'price'       => 595000,
                'stock'       => 28,
            ],
            [
                'category_id' => $pria->id,
                'name'        => 'Tapered Wool Trousers',
                'description' => 'Celana panjang berbahan wool gabardine dengan potongan tapered yang slim di bawah. Semi-formal dan cocok dipadukan dengan apa pun.',
                'price'       => 750000,
                'stock'       => 22,
            ],
            [
                'category_id' => $pria->id,
                'name'        => 'Structured Coach Jacket',
                'description' => 'Jaket coach dengan konstruksi terstruktur dari bahan nylon ripstop. Potongan oversized dengan detail minimal untuk estetika modern.',
                'price'       => 985000,
                'stock'       => 12,
            ],
            [
                'category_id' => $pria->id,
                'name'        => 'Organic Cotton Tee',
                'description' => 'Kaos berbahan organic cotton 180gsm. Potongan boxy dengan shoulder drop untuk kenyamanan maksimal. Tersedia hitam, putih, dan ecru.',
                'price'       => 295000,
                'stock'       => 50,
            ],

            // AKSESORIS
            [
                'category_id' => $aksesoris->id,
                'name'        => 'Leather Mini Tote Bag',
                'description' => 'Tas tote mini dari kulit sapi full-grain. Bagian dalam berlapis kain sutra dengan satu kompartemen utama dan slot kartu.',
                'price'       => 1450000,
                'stock'       => 8,
            ],
            [
                'category_id' => $aksesoris->id,
                'name'        => 'Merino Wool Scarf',
                'description' => 'Selendang dari 100% merino wool Selandia Baru. Tekstur ultra-lembut dengan dimensi 70x200cm. Cocok digunakan sepanjang tahun.',
                'price'       => 385000,
                'stock'       => 18,
            ],
            [
                'category_id' => $aksesoris->id,
                'name'        => 'Minimal Leather Belt',
                'description' => 'Sabuk kulit dengan buckle stainless matte. Tebal 3cm dengan permukaan mulus tanpa emboss. Tersedia hitam dan cokelat cognac.',
                'price'       => 325000,
                'stock'       => 25,
            ],
        ];

        foreach ($products as $item) {
            Product::create(array_merge($item, [
                'slug'      => Str::slug($item['name']) . '-' . Str::random(4),
                'is_active' => true,
            ]));
        }
    }
}
