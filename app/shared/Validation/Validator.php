<?php

namespace App\Shared\Validation;

use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;

final class Validator
{
    protected array $errors = [];

    public function validate(ServerRequestInterface $request, array $rules): Validator
    {
        foreach ($rules as $field => $rule) {
            try {
                $getParsedBody = (array)$request->getParsedBody() ?: [];
                $rule->setName($field)->assert($getParsedBody[$field]);
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    public function failed(): bool
    {
        return !empty($this->errors);
    }
}
