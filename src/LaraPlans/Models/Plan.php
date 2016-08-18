<?php

namespace Gerardojbaez\LaraPlans\Models;

use Illuminate\Database\Eloquent\Model;
use Gerardojbaez\LaraPlans\Contracts\PlanInterface;

class Plan extends Model implements PlanInterface
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'code',
        'price',
        'interval',
        'interval_count',
        'trial_period_days',
        'sort_order',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * Boot function for using with User Events.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            if ( ! $model->code)
                $model->code = str_random(10);

            if ( ! $model->interval)
                $model->interval = 'month';

            if ( ! $model->interval_count)
                $model->interval_count = 1;
        });
    }

    /**
     * Get plan features.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function features()
    {
        return $this->hasMany(config('laraplans.models.plan_feature'));
    }

    /**
     * Get plan subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(config('laraplans.models.plan_subscription'));
    }

    /**
     * Check if plan is free.
     *
     * @return boolean
     */
    public function isFree()
    {
        return ($this->price === 0.00 OR $this->price < 0.00);
    }

    /**
     * Check if plan has trial.
     *
     * @return boolean
     */
    public function hasTrial()
    {
        return (is_numeric($this->trial_period_days) AND $this->trial_period_days > 0);
    }

    /**
     * Scope by Code.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $Code
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCode($query, $code)
    {
        return $query->whereCode($code);
    }
}
