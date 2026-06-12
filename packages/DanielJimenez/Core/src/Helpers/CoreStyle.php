<?php

namespace DanielJimenez\Core\Helpers;

class CoreStyle
{
    public static function all(): array
    {
        return [
            'success' => [
                'border'    => 'border-success/30',
                'container' => 'bg-success/10',
                'bar'       => 'bg-success',
                'icon'      => 'bg-success/20 text-success',
                'text'      => 'text-success',
                'button'    => 'border-success bg-success/20 text-emerald-800 dark:text-emerald-300 hover:bg-success/30 focus-visible:outline-success'
            ],
            'danger' => [
                'border'    => 'border-danger/30',
                'container' => 'bg-danger/10',
                'bar'       => 'bg-danger',
                'icon'      => 'bg-danger/20 text-danger',
                'text'      => 'text-danger',
                'button'    => 'border-danger bg-danger/20 text-rose-800 dark:text-rose-300 hover:bg-danger/30 focus-visible:outline-danger'
            ],
            'error' => [
                'border'    => 'border-danger/30',
                'container' => 'bg-danger/10',
                'bar'       => 'bg-danger',
                'icon'      => 'bg-danger/20 text-danger',
                'text'      => 'text-danger',
                'button'    => 'border-danger bg-danger/20 text-rose-800 dark:text-rose-300 hover:bg-danger/30 focus-visible:outline-danger'
            ],
            'info' => [
                'border'    => 'border-info/30',
                'container' => 'bg-info/10',
                'bar'       => 'bg-info',
                'icon'      => 'bg-info/20 text-info',
                'text'      => 'text-info',
                'button'    => 'border-info bg-info/20 text-sky-800 dark:text-sky-300 hover:bg-info/30 focus-visible:outline-info'
            ],
            'warning' => [
                'border'    => 'border-warning/30',
                'container' => 'bg-warning/10',
                'bar'       => 'bg-warning',
                'icon'      => 'bg-warning/20 text-warning',
                'text'      => 'text-warning',
                'button'    => 'border-warning bg-warning/20 text-amber-800 dark:text-amber-300 hover:bg-warning/30 focus-visible:outline-warning'
            ],
            'normal' => [
                'border'    => 'border-zinc-200 dark:border-zinc-700',
                'container' => 'bg-zinc-50/60 dark:bg-zinc-900/20',
                'bar'       => 'bg-zinc-500',
                'icon'      => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400',
                'text'      => 'text-zinc-900 dark:text-zinc-100',
                'button'    => 'border-zinc-300 bg-zinc-100 text-zinc-800 hover:bg-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700'
            ]
        ];
    }

    public static function type(string $type): array
    {
        $styles = self::all();
        return $styles[$type] ?? $styles['normal'];
    }
}