<?php

namespace App\Models\AllUsers;

use App\Models\Core\AuthBaseModel;
use App\Models\PublicSettings\Role;


class Admin extends AuthBaseModel {

  const IMAGEPATH = 'admins';

  protected $fillable = [
    'name',
    'phone',
    'country_code',
    'email',
    'password',
    'image',
    'role_id',
    'is_notify',
    'is_blocked',
    'type',
  ];


  protected $casts = [
    'is_notify'  => 'boolean',
    'is_blocked' => 'boolean',
  ];

  public function role() {
    return $this->belongsTo(Role::class)->withTrashed();
  }

  /**
   * أعمدة التصدير (تظهر في مودال اختيار الأعمدة).
   * role.name من العلاقة يعرض اسم الصلاحية بدل role_id.
   */
  public function exportableColumns(): array
  {
    return [
      'id'          => '#',
      'name'        => __('admin.name'),
      'email'       => __('admin.email'),
      'phone'       => __('admin.phone'),
      'country_code' => __('admin.country_code'),
      'image'       => __('admin.image'),
      'role.name'   => __('admin.name_of_role'),
      'type'        => __('admin.type'),
      'is_blocked'  => __('admin.is_blocked'),
      'created_at'  => __('admin.created_at'),
    ];
  }

  /**
   * قيمة العمود عند التصدير (لتحويل البوليانات لنص واضح بدل 1/0).
   */
  public function getExportValue(string $column): mixed
  {
    return match ($column) {
      'is_blocked' => $this->is_blocked ? __('admin.is_blocked') : __('admin.not_blocked'),
      'is_notify'  => $this->is_notify ? __('admin.activate') : __('admin.dis_activate'),
      default     => data_get($this, $column),
    };
  }
}
