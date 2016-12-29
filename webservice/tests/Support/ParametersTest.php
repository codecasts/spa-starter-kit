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
            'order' => 'some_order',
        ]);

        $this->assertEquals('some_order', $parameters->order());
    }

    /** @test */
    public function can_get_sort()
    {
        $parameters = $this->getQueryParameterInstance([
            'sort' => 'column_name',
        ]);

        $this->assertEquals('column_name', $parameters->sort());
    }

    /** @test */
    public function can_get_limit()
    {
        $parameters = $this->getQueryParameterInstance([
            'limit' => 99,
        ]);

        $this->assertEquals(99, $parameters->limit());
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
     * Get a fresh instance of the query parameters class.
     *
     * @param  array  $parameters
     *
     * @return \App\Support\Parameters
     */
    private function getQueryParameterInstance($parameters = [])
    {
        return new Parameters(
            new Request($parameters)
        );
    }
}
