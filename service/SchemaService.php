<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Schema\Service;

use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

use Arikaim\Core\Service\Service;
use Arikaim\Core\Service\ServiceInterface;

/**
 * Schema service class
*/
class SchemaService extends Service implements ServiceInterface
{
    /**
     * Graph ref
     * @var object|null
     */
    protected $graph;

    /**
     * Boot service
     *
     * @return void
     */
    public function boot()
    {
        $this->setServiceName('schema');
    }

    /**
     * Create schema object
     *
     * @param string $name
     * @return mixed
     */
    public function schema(string $name)
    {
        return call_user_func(Schema::class . '::' . $name);
    }

    /**
     * Get graph
     * 
     * @return Graph|object|null
     */
    public function getGraph(): ?object
    {
        return $this->graph;
    }

    /**
     * Create graph
     * 
     * @param string|array|null $context
     * @return object
     */
    public function graph(string|array|null $context = null): object
    {
        $this->graph = new Graph($context);
        
        return $this->graph;
    }

    /**
     * To json
     * 
     * @return bool|string|null
     */
    public function toJson(): ?string
    {
        if ($this->graph == null) {
            return null;
        }

        return \json_encode($this->graph);
    }

    /**
     * Add script code to page head
     * 
     * @return void
     */
    public function addToPageHead(): void
    {
        global $arikaim;

        if ($this->graph == null) {
            return;
        }

        $arikaim->get('page')->head()->addHtmlCode($this->graph->toScript() . "\n\t\t");
    }
}
