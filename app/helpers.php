<?php

use App\Models\Employee;

function get_employee($employee_id){
    return Employee::find($employee_id);
}
