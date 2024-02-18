<?php

namespace App\Traits;

trait ConstantsTrait
{
    public static function values(): array
    {
        $data = [];
        foreach (self::cases() as $case) {
            $data[$case->value] = $case->label();
        }
        return $data;
    }

    public static function valuesCollection(): array
    {
        $data = [];
        foreach (self::cases() as $case) {
            $data[] = [
                'value' => $case->value,
                'txt' => $case->label(),
                'color' => method_exists($case, 'color') ? $case->color() : ''
            ];
        }
        return $data;
    }

    public function is($value): bool
    {
        return $this === $value;
    }
}
