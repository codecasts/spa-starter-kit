<?php

use App\Support\Parameters;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParametersTest extends TestCase
{
    /** @test */
    public function can_get_order()
    {
        $parameters = $this->getQueryParameterInstance([
            'order' => 'desc',
        ]);

        $this->assertEquals('desc', $parameters->order());
    }

    /** @test */
    public function can_get_sort()
    {
        $parameters = $this->getQueryParameterInstance([
            'sort' => 'id',
        ]);

        $this->assertEquals('id', $parameters->sort());
    }

    /** @test */
    public function can_get_limit()
    {
        $parameters = $this->getQueryParameterInstance([
            'limit' => 10,
        ]);

        $this->assertEquals(10, $parameters->limit());
    }

    /** @test */
    public function can_get_query_parameter_from_request()
    {
        $parameters = $this->getQueryParameterInstance([
            'some_parameter' => 'some value',
        ]);

        $this->assertEquals('some value', $parameters->get('some_parameter'));
    }

    /**
     * Get a fresh instance of QueryParameter class.
     *
     * @param  array  $parameters
     *
     * @return \App\Support\QueryParameter
     */
    private function getQueryParameterInstance($parameters = [])
    {
        return new Parameters(
            new Request($parameters)
        );
    }
}
