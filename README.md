#Stack Instance Api Server bundle

## How to install
composer require stackinstance/api-server-bundle

## Routing to see an example:
```YML
stack_instance_api_server:
    resource: "@StackInstanceApiServerBundle/Resources/config/routing.yml"
    prefix:   /
```

## Tables creating for the example
php app/console doctrine:schema:update --force

## Website
- https://raymondkootstra.nl
