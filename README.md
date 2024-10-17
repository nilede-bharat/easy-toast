# Notification for Laravel + Inertia + Vue js

This package provide integration easily show notification 

## Installation

You can easily install this library using Composer. Just request the package with the following command:

```bash
composer require nilede-bharat/easy-toast
```
if getting any error install this package using composer:

```bash
composer require nilede-bharat/easy-toast --ignore-platform-reqs
```


## Configuration

1.publish ToastNotification Component file

```bash
php artisan vendor:publish --tag=Bharat\EasyToast\EasyToastServiceProvider
```


2.Register notification in HandleInertiaRequests  App\Http\Middleware\HandleInertiaRequests

```php

<?php

namespace App\Http\Middleware;
use App\Traits\ToastNotificationTrait;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    use ToastNotificationTrait;
    
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            ...$this->init(),
        ]);
    }
}

```


3.Register notification in base controller  App\Http\Controllers\Controller its optional

```php
<?php

namespace App\Http\Controllers;
use App\Traits\ToastNotificationTrait;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ToastNotificationTrait;
}

```


4.import Toast Notification component in main layout 

```vue
<template>
  <div>
    <ToastNotification/>
    <main>
      <slot/>
    </main>
  </div>
</template>

<script setup>
  import ToastNotification from "@/Components/ToastNotification.vue";
</script>
```

## Usage 

Create notification in any controller  

```php
<?php

namespace App\Http\Controllers;


class AdmissionController extends Controller
{
    public function store() {
    
        // this code available when 
        // 3.Register notification in base controller  App\Http\Controllers\Controller its optional
        $this->success('message');
        $this->error('message');
        $this->warning('message');
        
        // OR
        return redirect()->back()->with('success','message');
        // OR
        return redirect()->back()->with('error','message');
        // OR
        return redirect()->back()->with('message','message');
    }
}
```


