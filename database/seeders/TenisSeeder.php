<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenis;

class TenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenis = [
            [
                'nombre' => 'Nike Air Force 1 07',
                'marca' => 'Nike',
                'precio' => 2399.00,
                'talla' => '27.5 MX',
                'color' => 'Blanco Puro',
                'imagen' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=800&auto=format&fit=crop',
                'descripcion' => 'El resplandor sigue vivo en el Nike Air Force 1 07, el modelo de básquetbol original que le da un toque innovador a lo que mejor conoces: revestimientos con costuras duraderas y acabados impecables.',
            ],
            [
                'nombre' => 'Air Jordan 1 Retro High',
                'marca' => 'Jordan',
                'precio' => 3899.00,
                'talla' => '28.0 MX',
                'color' => 'Rojo / Negro / Blanco',
                'imagen' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?q=80&w=800&auto=format&fit=crop',
                'descripcion' => 'Un clásico indiscutible. El Air Jordan 1 Retro High combina cuero premium con amortiguación Air-Sole para una comodidad duradera inspirada en el calzado original de 1985.',
            ],
            [
                'nombre' => 'Adidas Superstar Originals',
                'marca' => 'Adidas',
                'precio' => 1999.00,
                'talla' => '27.0 MX',
                'color' => 'Blanco con Franjas Negras',
                'imagen' => 'https://images.unsplash.com/photo-1518002171953-a080ee817e1f?q=80&w=800&auto=format&fit=crop',
                'descripcion' => 'Nacidos en las canchas de baloncesto en los años 70 y celebrados por la realeza del hip-hop en los 80, los tenis Adidas Superstar son el ícono indiscutible del estilo urbano.',
            ],
            [
                'nombre' => 'Puma Suede Classic XXI',
                'marca' => 'Puma',
                'precio' => 1699.00,
                'talla' => '26.5 MX',
                'color' => 'Negro / Blanco',
                'imagen' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?q=80&w=800&auto=format&fit=crop',
                'descripcion' => 'Los Puma Suede han cambiado las reglas del juego desde 1968. Confeccionados con ante de primera calidad y el icónico Formstrip en el lateral.',
            ],
            [
                'nombre' => 'Vans Old Skool Classic',
                'marca' => 'Vans',
                'precio' => 1499.00,
                'talla' => '27.0 MX',
                'color' => 'Negro con Sidestripe Blanco',
                'imagen' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=800&auto=format&fit=crop',
                'descripcion' => 'El primer calzado para skate con la legendaria franja Sidestripe. Cuentan con pala de lona resistente, puntera reforzada y la inconfundible suela waffle de caucho.',
            ],
            [
                'nombre' => 'New Balance 550 Retro',
                'marca' => 'New Balance',
                'precio' => 2799.00,
                'talla' => '28.0 MX',
                'color' => 'Blanco / Gris',
                'imagen' => 'https://images.unsplash.com/photo-1539185441755-769473a23570?q=80&w=800&auto=format&fit=crop',
                'descripcion' => 'Un tributo a los jugadores profesionales de básquetbol de los 80 y a la ropa urbana que definió a toda una generación. Sencillos, limpios y fieles a su legado.',
            ],
        ];

        foreach ($tenis as $item) {
            Tenis::firstOrCreate(
                ['nombre' => $item['nombre']],
                $item
            );
        }
    }
}
