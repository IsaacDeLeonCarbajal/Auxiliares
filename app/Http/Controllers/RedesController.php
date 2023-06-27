<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedesController extends Controller
{
    const CLASES = [
        'A' => [
            'indice' => 1,
            'min' => 1,
            'max' => 126,
        ],
        'B' => [
            'indice' => 2,
            'min' => 128,
            'max' => 191,
        ],
        'C' => [
            'indice' => 3,
            'min' => 192,
            'max' => 223,
        ],
    ];

    public function obtenerDirecciones($clase = 'B', $cantidad = 8)
    {
        $direcciones = [];

        for ($i = 0; $i < $cantidad; $i++) {
            array_push($direcciones, $this->crearDireccionAleatoria($clase));
        }

        return view('direcciones.direcciones', compact('direcciones'));
    }

    public function obtenerSubneteo($clase = 'B', $subredes = 8)
    {
        $indice = RedesController::CLASES[$clase]['indice'];
        $direccion = $this->crearDireccionAleatoria($clase);
        $submascara = [];
        $subredes = $subredes;
        $n = 1;
        $m = 1;
        $r = 10;
        $subOcteto = 0;
        $salto = 0;

        for ($i = 0; $i < 4; $i++) {
            array_push($submascara, $i < $indice ? 255 : 0);
        }

        do {
            $n++;
        } while (($r = (pow(2, $n) - 2)) < $subredes);

        $m = ((4 - $indice) * 8) - $n;

        for ($i = 8; $i > (8 - $n); $i--) {
            $subOcteto += pow(2, ($i - 1));
        }

        $salto = 256 - $subOcteto;

        $datosDirecciones = [];

        for ($i = 0; $i < $subredes; $i++) {
            $datos = [
                'Red' => array_replace($direccion, [$indice => $i * $salto]),
                'PrimeraUtil' => array_replace($direccion, [$indice => ($i * $salto)]),
                'UltimaUtil' => array_replace($direccion, [$indice => (($i + 1) * $salto)]),
                'Broadcast' => array_replace($direccion, [$indice => (($i + 1) * $salto)]),
            ];

            $datosDirecciones += [($i + 1) => [
                'Red' => $datos['Red'],
                'PrimeraUtil' => $this->obtenerDireccion($datos['PrimeraUtil'], 1),
                'UltimaUtil' => $this->obtenerDireccion($datos['UltimaUtil'], -2),
                'Broadcast' => $this->obtenerDireccion($datos['Broadcast'], -1),
            ]];
        }

        // Generar el subneteo de la red
        return view('subneteo.subneteo', compact('direccion', 'submascara', 'subredes', 'n', 'r', 'm', 'indice', 'subOcteto', 'salto', 'datosDirecciones'));
    }

    private function crearDireccionAleatoria($clase)
    {
        $indice = RedesController::CLASES[$clase]['indice'];
        $direccion = [rand(RedesController::CLASES[$clase]['min'], RedesController::CLASES[$clase]['max'])];

        for ($j = 1; $j < 4; $j++) {
            array_push($direccion, $j < $indice ? rand(0, 255) : 0);
        }

        return $direccion;
    }

    private function obtenerOcteto($original, $diferencia)
    {
        $resultado = $original + $diferencia;

        return $resultado < 0 ? $resultado += 256 : $resultado;
    }

    private function obtenerDireccion(array $original, int $dif)
    {
        $direccion = $original;

        for ($i = 3; $i >= 0; $i--) {
            $direccion = array_replace($direccion, [$i => $this->obtenerOcteto($original[$i], $dif)]);

            if (($original[$i] + $dif) > 255) {
                $dif = 1;
            } else if (($original[$i] + $dif) < 0) {
                $dif = -1;
            } else {
                $dif = 0;
            }
        }

        return $direccion;
    }
}
