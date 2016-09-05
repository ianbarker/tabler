<?php

namespace eznio\db\tests\renderers;


use eznio\tabler\renderers\MysqlStyleRenderer;
use eznio\tabler\Tabler;

class MysqlStyleRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider formatterTestData
     *
     * @param $sourceData
     * @param $sourceHeaders
     * @param $shouldGuess
     * @param $expectedOutput
     */
    public function proceedWithTests($sourceData, $sourceHeaders, $shouldGuess, $expectedOutput)
    {
        $tabler = (new Tabler())
            ->setData($sourceData)
            ->setHeaders($sourceHeaders)
            ->setGuessHeaderNames($shouldGuess)
            ->setRenderer(new MysqlStyleRenderer());

        $this->assertEquals(
            $expectedOutput,
            $tabler->render()
        );
    }

    public function formatterTestData()
    {
        return [
            [   // Test 1
                [
                    ['1', '2', '3'],
                    ['1', '2', '3'],
                ],
                [
                    'column1', 'column2', 'column3'
                ],
                false,
                <<<TABLE
+---------+---------+---------+
| column1 | column2 | column3 |
+---------+---------+---------+
| 1       | 2       | 3       |
| 1       | 2       | 3       |
+---------+---------+---------+

TABLE
            ],  // Test 1 ends

            [   // Test 2
                [
                    ['1', '2', '3'],
                ],
                [
                    'column1', 'column2', 'column3'
                ],
                false,
                <<<TABLE
+---------+---------+---------+
| column1 | column2 | column3 |
+---------+---------+---------+
| 1       | 2       | 3       |
+---------+---------+---------+

TABLE
            ],  // Test 2 ends

            [   // Test 3
                [
                    ['1'],
                    ['2'],
                    ['3'],
                ],
                [
                    'column1'
                ],
                false,
                <<<TABLE
+---------+
| column1 |
+---------+
| 1       |
| 2       |
| 3       |
+---------+

TABLE
            ],  // Test 3 ends

            [   // Test 4
                [
                ],
                [
                ],
                false,
                <<<TABLE
+
|
+
+

TABLE
            ],  // Test 4 ends

            [   // Test 5
                [
                    ['a' => '1'],
                    ['b' => '2'],
                    ['c' => '3'],
                ],
                [],
                true,
                <<<TABLE
+---+---+---+
| a | b | c |
+---+---+---+
| 1 |   |   |
|   | 2 |   |
|   |   | 3 |
+---+---+---+

TABLE
            ],  // Test 5 ends

            [   // Test 6
                [
                    ['a' => '1'],
                    ['b' => '2'],
                    ['c' => '3'],
                ],
                [
                    'a' => 'Column A',
                    'b' => 'Column B',
                    'c' => 'Column C',
                ],
                false,
                <<<TABLE
+----------+----------+----------+
| Column A | Column B | Column C |
+----------+----------+----------+
| 1        |          |          |
|          | 2        |          |
|          |          | 3        |
+----------+----------+----------+

TABLE
            ],  // Test 6 ends

            [   // Test 7
                [
                    ['a' => '1'],
                    ['b' => '2'],
                    ['c' => '3'],
                ],
                [
                    'a' => 'Column A',
                    'd' => 'Column D',
                ],
                false,
                <<<TABLE
+----------+----------+---+---+
| Column A | Column D |   |   |
+----------+----------+---+---+
| 1        |          |   |   |
|          |          | 2 |   |
|          |          |   | 3 |
+----------+----------+---+---+

TABLE
            ],  // Test 7 ends
        ];
    }
}
