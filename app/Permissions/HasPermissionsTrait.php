<?php

namespace App\Permissions;

//use App\Models\Permission;
use App\Models\ClearanceArea;
use App\Models\Role;
use App\Models\User;

trait HasPermissionsTrait {

    public function givePermissionsTo(... $permissions) {

    $permissions = $this->getAllPermissions($permissions);
    if($permissions === null) {
      return $this;
    }

    $this->permissions()->saveMany($permissions);
    return $this;

  }

  public function withdrawPermissionsTo( ... $permissions ) {

    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;

  }

  public function refreshPermissions( ... $permissions ) {

    $this->permissions()->detach();
    return $this->givePermissionsTo($permissions);

  }

  public function hasPermissionTo($permission) {

    return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);

  }

  public function hasPermissionThroughRole($permission) {

    foreach ($permission->clearance_areas as $role){
      if($this->clearance_areas->contains($role)) {
        return true;
      }
    }
    return false;

  }

  public function hasClearanceAreaRole( ... $clearance_areas ) {

    foreach ($clearance_areas as $role) {
      if ($this->clearance_areas->contains('clearance_area_id', $role)) {
        return true;
      }
    }
    return false;

  }

  public function hasRole( ... $roles ) {

    foreach ($roles as $role) {
      if ($this->roles->contains('role_id', $role)) {
        return true;
      }
    }
    return false;

  }

  public function clearance_areas() {
    return $this->setConnection('iclearance_connection')->belongsToMany(ClearanceArea::class,'authorize_employee','account_id','clearance_area_id');

  }

  public function roles() {
    return $this->setConnection('iclearance_connection')->belongsToMany(Role::class,'account_role','account_id','role_id');

  }

  public function permissions() {

    return $this->belongsToMany(Permission::class,'users_permissions');

  }
  protected function hasPermission($permission) {

    return (bool) $this->permissions->where('code', $permission->slug)->count();
  }

  protected function getAllPermissions(array $permissions) {

   // return Permission::whereIn('slug',$permissions)->get();
    
  }
}