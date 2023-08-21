# Installasi laravel passport


1. Install laravel passport library via composer `composer require laravel/passport`
2. Migrasi database tabel laravel passport `php artisan migrate`, setelah di jalankan table oauth_* akan tercreate dalam database
3. Install laravel passport `php artisan passport:install`
4. Setelah passport terinstall maka :
   - Terdapat 2 file dalam folder storage : oauth-private.key dan oauth-public.key
   - Terdapat 2 row dalam tabel oauth_clients(Laravel Personal Access Client & Laravel Password Grant Client)

5. Jika item dalam step no 4 di atas tidak terpenuhi, maka di perlukan generate key dan passport client secara manual, dengan langkah2 sbb :
    - buat passport key `php artisan passport:keys`, maka tercreate 2 file dalam folder storage (oauth-private.key dan oauth-public.key)
    - buat access client  dengan type Password Grant Client `php artisan passport:client`, ikuti command selanjutnya.maka akan tercreate client access dengan type Password Grant Client dalam tabel oauth_clients
    - buat access client  dengan type Personal Access Client `php artisan passport:client --personal`, ikuti command selanjutnya.maka akan tercreate client access dengan type Personal Access Client dalam tabel oauth_clients
   
   ** Dalam aplikasi yang kita gunakan , menggunakan access client Personal Access Token



# Konfigurasi laravel passport

1. Publish konfigurasi laravel passport `php artisan vendor:publish --tag=passport-config`
2. Tambahkan konfig encryption keys dibawah ini dalam file .env 
    ```bash
    PASSPORT_PRIVATE_KEY="-----BEGIN RSA PRIVATE KEY-----
    <private key here>
    -----END RSA PRIVATE KEY-----"
     
    PASSPORT_PUBLIC_KEY="-----BEGIN PUBLIC KEY-----
    <public key here>
    -----END PUBLIC KEY-----"
    ```
3. ganti isi PASSPORT_PRIVATE_KEY dengan text dalam file /storage/oauth-private.key
4. ganti isi PASSPORT_PUBLIC_KEY dengan text dalam file /storage/oauth-public.key
5. setiap perubahan dalam file .env atau file dalam folder config jangan lupa menjalankan command `php artisan config:cache`
6. dalam file \App\Providers\AuthServiceProvider.php tambahkan sesuai baris berikut :

    ```php
   public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
        #default lifetime token akan expired setelah 1 tahun, jika ingin membatasi token lifetime bisa menambahkan seperti dibawah
        //Passport::tokensExpireIn(now()->addDays(15));
        //Passport::refreshTokensExpireIn(now()->addDays(30));
        //Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    
   }
   ```
7. dalam file config/auth.php tambahkan guard api menggunakan driver passport

   ```php
      'guards' => [
           'web' => [
               'driver' => 'session',
               'provider' => 'users',
           ],
     
           'api' => [
               'driver' => 'passport',
               'provider' => 'users',
           ],
       ],
   
      ```

8. dalam file App\Models\User.php pastikan terdapat trait HasApiTokens dengan use use Laravel\Passport\HasApiTokens;

    ```php
        <?php

        namespace App\Models;
    
        use Illuminate\Contracts\Auth\MustVerifyEmail;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Foundation\Auth\User as Authenticatable;
        use Illuminate\Notifications\Notifiable;
        use Laravel\Passport\HasApiTokens;
    
        class User extends Authenticatable
        {
            use HasApiTokens, HasFactory, Notifiable;

    ```

# Memanfaatkan Oauth Scope untuk role / Hak Akses

misal terdapat role user Admin,Supervisor,Kasir, dalam file \App\Providers\AuthServiceProvider.php perlu menambakan sesuai dibawah ini :

```php
public function boot()
{
    $this->registerPolicies();

    if (! $this->app->routesAreCached()) {
        Passport::routes();
    }
    #menambahkan scope untuk role
    Passport::tokensCan([
        'admin' => 'Hak Akses Administrator',
        'supervisor' => 'Hak Akses Superisor',
        'cashier' => 'Hak Akses Kasir',
    ]);
    
    #default lifetime token akan expired setelah 1 tahun, jika ingin membatasi token lifetime bisa menambahkan seperti dibawah
    //Passport::tokensExpireIn(now()->addDays(15));
    //Passport::refreshTokensExpireIn(now()->addDays(30));
    //Passport::personalAccessTokensExpireIn(now()->addMonths(6));

}
```
