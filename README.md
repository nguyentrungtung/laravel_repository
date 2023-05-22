
## Require if run project docker

```
- install docker for machine
```

## Installing

```
- git pull origin ....
- docker compose build --no-cache
- docker compose up -d
```

## Note
```
-- guide see via Geting Start
-- Guide see git flow in geting start 
-- Guide see codeing convention in geting start
-- if start project docker see command guide see geting start
```


## dependency injection project
```
-- laravel/ui
-- barryvdh/laravel-ide-helper
-- barryvdh/laravel-debugbar
-- laravelcollective/html
-- ckfinder/ckfinder-laravel-package
-- composer require tightenco/duster --dev
```

## Install deployment Project
```
-- git clone project
-- cp .env.example -> .env
-- cd projectName -> run composer install
-- php artisan key:generate
-- php artisan migrate:refresh
-- php artisan db:seed
-- php artisan serve ( prioritize config nginx server run project )
```

## Web
```
-- http:localhost:8000/login ( dashboard login admin )
```

## artisan command support make repository cmd

#### create repository

- php artisan make:repository name_repository

## Generate coding conversion beautifully

## Usage

To lint everything at once:

```bash
./vendor/bin/duster lint
```

To fix everything at once:

```bash
./vendor/bin/duster fix
```

To dust only files that have uncommitted changes according to Git, you may use the `--dirty` option:

```bash
./vendor/bin/duster lint --dirty
#or
./vendor/bin/duster fix --dirty
```

To view all available commands:

```bash
./vendor/bin/duster
#or
./vendor/bin/duster commands
```

#### generate php doc comment
- php artisan ide-helper:models "App\Models\Post"
```
/**
 * App\Models\Post
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $title
 * @property string $text
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \User $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\Comment[] $comments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post forAuthors(\User ...$authors)
 * …
 */
```
- php artisan ide-helper:generate

