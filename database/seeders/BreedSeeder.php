<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Seeder;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $breeds = [
            [
                'name' => 'Bifolo',
                'description' => 'Sapi hasil persilangan antara sapi Bali (Bos javanicus) dan sapi Simental (Bos taurus). Memiliki tubuh padat, daya adaptasi tinggi terhadap iklim tropis, dan produktivitas daging yang baik. Dikembangkan di Indonesia untuk meningkatkan kualitas sapi potong lokal.',
            ],
            [
                'name' => 'Biru Belgia',
                'description' => 'Bangsa sapi pedaging unggul asal Belgia yang dikenal karena fenomena "double muscling" — pertumbuhan otot berlipat akibat mutasi gen miostatin. Memiliki daging sangat rendah lemak dan persentase karkas tinggi, populer di industri daging premium.',
            ],
            [
                'name' => 'Hereford',
                'description' => 'Sapi pedaging asal Herefordshire, Inggris. Ciri khas: wajah putih (white face) dan tubuh merah kecokelatan. Sifatnya jinak, mudah beradaptasi, efisien dalam konversi pakan, serta menghasilkan daging marbling yang baik. Banyak digunakan dalam program persilangan.',
            ],
            [
                'name' => 'Sapi Aceh',
                'description' => 'Sapi lokal asli Aceh yang termasuk tipe sapi potong kecil. Berukuran relatif kecil, namun sangat adaptif terhadap lingkungan marginal dan pakan berkualitas rendah. Memiliki ketahanan terhadap penyakit parasit tropis dan kemampuan reproduksi yang baik.',
            ],
            [
                'name' => 'Sapi Madura',
                'description' => 'Sapi lokal asli Indonesia dari Pulau Madura, hasil persilangan alami antara sapi Bali (Bos javanicus) dan sapi Zebu (Bos indicus). Ciri khas: punuk kecil, warna merah bata, dan telinga menggantung. Digunakan sebagai sapi potong sekaligus sapi kerapik (sapi sonok) untuk budaya karapan sapi.',
            ],
            [
                'name' => 'Angus',
                'description' => 'Sapi pedaging asal Skotlandia yang terkenal dengan kualitas daging marbling tinggi dan tidak bertanduk (polled). Warna tubuh hitam solid (Black Angus) atau merah (Red Angus). Dagingnya sering menjadi standar premium di industri restoran steak.',
            ],
            [
                'name' => 'Brangus',
                'description' => 'Sapi hasil persilangan antara Brahman (Bos indicus, 3/8) dan Angus (Bos taurus, 5/8) untuk menggabungkan ketahanan panas/kutu dari Brahman dengan kualitas daging marbling dari Angus. Populer di daerah tropis dan subtropis, termasuk Indonesia.',
            ],
            [
                'name' => 'Sapi Jabres',
                'description' => 'Sapi lokal asli dari daerah Brebes dan sekitarnya, Jawa Tengah. Merupakan tipe sapi potong kecil yang tangguh di lahan kering. Warnanya bervariasi dari kuning kemerahan hingga hitam. Daya adaptasi tinggi terhadap pakan berkualitas rendah dan lingkungan panas.',
            ],
        ];

        foreach ($breeds as $breed) {
            Breed::firstOrCreate(
                ['name' => $breed['name']],
                ['description' => $breed['description']]
            );
        }

        $this->command->info('BreedSeeder: ' . count($breeds) . ' breeds added/verified successfully.');
    }
}
