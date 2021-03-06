<?php

class YamlLikeIndentationParserTest extends PHPUnit_Framework_TestCase
{
    public function testBase()
    {
        $parser = new \ParserGenerator\Examples\YamlLikeIndentationParser();

        $this->assertEquals(array("a" => "x"), $parser->getValue("a:x"));
        $this->assertEquals(array(
            "a" => "x",
            "b" => "y"
        ), $parser->getValue("
            a:x
            b:y"));
    }

    public function testIndentsBase()
    {
        $parser = new \ParserGenerator\Examples\YamlLikeIndentationParser();

        $this->assertEquals(array(
            "a" => array(
                "b" => "x"
            )
        ), $parser->getValue("
            a:
             b:x"));
    }

    public function testIndentsCanBeAnyNumberOfSpaces()
    {
        $parser = new \ParserGenerator\Examples\YamlLikeIndentationParser();

        $this->assertEquals(array(
            "a" => array(
                "b" => "x"
            )
        ), $parser->getValue("
            a:
                         b:x"));
    }

    public function testIndentsMultilevel()
    {
        $parser = new \ParserGenerator\Examples\YamlLikeIndentationParser();

        $this->assertEquals(array(
            "a" => array(
                "b" => array(
                    "c" => array(
                        "d" => array(
                            "e" => "x"
                        )
                    )
                )
            )
        ), $parser->getValue("
            a:
              b:
                c:
                  d:
                    e:x"));
    }

    public function testIndentsSignificance()
    {
        $parser = new \ParserGenerator\Examples\YamlLikeIndentationParser();

        $this->assertEquals(array(
            "a" => array(
                "b" => array(
                    "c" => "x",
                    "d" => "y"
                )
            )
        ), $parser->getValue("
            a:
              b:
                c:x
                d:y"));

        $this->assertEquals(array(
            "a" => array(
                "b" => array(
                    "c" => "x"
                ),
                "d" => "y"
            )
        ), $parser->getValue("
            a:
              b:
                c:x
              d:y"));

        $this->assertEquals(array(
            "a" => array(
                "b" => array(
                    "c" => "x"
                )
            ),
            "d" => "y"
        ), $parser->getValue("
            a:
              b:
                c:x
            d:y"));

        // indentation level doesn't match
        $this->assertEquals(false, $parser->getValue("
            a:
              b:
                c:x
             d:y"));

        // indentation level doesn't match
        $this->assertEquals(false, $parser->getValue("
            a:
              b:
                c:x
               d:y"));
    }

    public function testComplexExample()
    {
        $parser = new \ParserGenerator\Examples\YamlLikeIndentationParser();

        $this->assertEquals(array(
            "a" => array(
                "b" => array(
                    "c" => "1",
                    "d" => "2"
                ),
                "e" => array(
                    "f" => array(
                        "g" => "3",
                        "h" => "4"
                    )
                ),
                "i" => "5",
                "j" => "6",
                "k" => array(
                    "l" => array(
                        "m" => "7"
                    ),
                    "n" => "8",
                    "o" => "9"
                ),
                "p" => "10"
            )
        ), $parser->getValue("
            a:
              b:
                c:1
                d:2
              e:
                f:
                  g:3
                  h:4
              i:5
              j:6
              k:
                l:
                  m:7
                n:8
                o:9
              p:10"));
    }
}
