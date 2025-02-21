- Agora me ajude a criar via comando as seeders, factories, models, migrations e tudo mais necessario para as tabelas materials e moviment. Os nomes das tabelas devem ser em ingles.

Vou guiá-lo passo a passo para criar todo o ecossistema necessário para as tabelas `materials` e `movements` (em inglês) usando os comandos do Artisan.

---

### **1. Criar Models, Migrations e Factories**

Execute os comandos para criar os **models** (com migrations e factories):

```bash
php artisan make:model Material -mf
php artisan make:model Movement -mf
```

Isso criará:
- Models: `app/Models/Material.php` e `app/Models/Movement.php`
- Migrations: `database/migrations/xxxx_create_materials_table.php` e `xxxx_create_movements_table.php`
- Factories: `database/factories/MaterialFactory.php` e `database/factories/MovementFactory.php`

---

### **2. Editar as Migrations**

**Migration `create_materials_table.php`**:
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->integer('minimum_stock');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
};
```

**Migration `create_movements_table.php`**:
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['entry', 'exit']);
            $table->integer('quantity');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movements');
    }
};
```

---

### **3. Configurar os Models**

**Model `Material.php`**:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'minimum_stock',
        'unit_price'
    ];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
```

**Model `Movement.php`**:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'type',
        'quantity',
        'observation'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
```

---

### **4. Configurar as Factories**

**MaterialFactory.php**:
```php
namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(0, 100),
            'minimum_stock' => $this->faker->numberBetween(10, 20),
            'unit_price' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
```

**MovementFactory.php**:
```php
namespace Database\Factories;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovementFactory extends Factory
{
    protected $model = Movement::class;

    public function definition()
    {
        return [
            'material_id' => \App\Models\Material::factory(),
            'type' => $this->faker->randomElement(['entry', 'exit']),
            'quantity' => $this->faker->numberBetween(1, 20),
            'observation' => $this->faker->sentence,
        ];
    }
}
```

---

### **5. Criar e Configurar os Seeders**

Crie os seeders e edite-os:

```bash
php artisan make:seeder MaterialSeeder
php artisan make:seeder MovementSeeder
```

**MaterialSeeder.php**:
```php
namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run()
    {
        Material::factory(10)->create();
    }
}
```

**MovementSeeder.php**:
```php
namespace Database\Seeders;

use App\Models\Movement;
use Illuminate\Database\Seeder;

class MovementSeeder extends Seeder
{
    public function run()
    {
        Movement::factory(50)->create();
    }
}
```

**DatabaseSeeder.php**:
```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            MaterialSeeder::class,
            MovementSeeder::class,
        ]);
    }
}
```

---

### **6. Executar Migrations e Seeders**

Execute os comandos finais:

```bash
php artisan migrate
php artisan db:seed
```

Isso criará as tabelas e populará o banco de dados com dados de teste.

---

### **Verificação Final**

1. **Acesse o Adminer** (`http://localhost:8080`) e verifique as tabelas `materials` e `movements`.
2. **Teste o Dashboard** para garantir que os dados estão sendo exibidos corretamente.

Se precisar de ajustes adicionais, é só pedir! 🚀