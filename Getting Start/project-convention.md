## Basic conding and coding style

Please flow psr-1 and psr-2 convention flow 2 file on folder `psr`

If you're using windows please run this command for disable CRLF auto replace 

``git config --global core.safecrlf false``

### 1.1 Declare variable guide
Declare a variable that needs to be related to the object to be referenced.
For example: 
```php
$student = new \App\Models\Student()
```
### 1.2 String
Please consider `'` or `"` for string. Code bellow is example
- If string don't have variable you should use `'`
- If string have variable you should use `"` or `sprintf` function
```php
$message = 'This is a message';
$hello   = "Hello ${name}"
$helloWord = sprintf('Hello %s', $name)
```

### 2. Git convention

Please flow this guide.

Please flow `git-flow.md`

### 3. Repository pattern

Please flow `repository-pattern.md`

### 4. Commit convention
Please flow commit convention below
```php
<type>[optional scope]: <description>

[optional body]

[optional footer(s)]
```
For detail please read this reference link [conventionalcommits](https://www.conventionalcommits.org/en/v1.0.0/)
