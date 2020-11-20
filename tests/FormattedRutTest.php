<?php

namespace MNC\ChileanRut;

use PHPUnit\Framework\TestCase;

/**
 * Class FormattedRutTest
 * @package MNC\ChileanRut
 */
class FormattedRutTest extends TestCase
{
    public function testItFormatsHyphened(): void
    {
        $formatted = (string) Rut::parse('168943652')->format()->hyphened();
        self::assertSame('16894365-2', $formatted);
    }

    public function testItFormatsDotted(): void
    {
        $formatted = (string) Rut::parse('168943652')->format()->dotted();
        self::assertSame('16.894.3652', $formatted);
    }

    public function testItFormatsHyphenedAndDotted(): void
    {
        $formatted = (string) Rut::parse('168943652')->format()->hyphened()->dotted();
        self::assertSame('16.894.365-2', $formatted);
    }

    public function testItFormatsObfuscated(): void
    {
        $formatted = (string) Rut::parse('168943652')->format()->obfuscated();
        self::assertSame('*****3652', $formatted);
    }

    public function testItFormatsObfuscatedAndHyphened(): void
    {
        $formatted = (string) Rut::parse('168943652')->format()->hyphened()->obfuscated();
        self::assertSame('*****365-2', $formatted);
    }

    public function testItFormatsObfuscatedAndDotted(): void
    {
        $formatted = (string) Rut::parse('168943652')->format()->obfuscated()->dotted();
        self::assertSame('**.***.3652', $formatted);
    }

    public function testItFormatsWithAll(): void
    {
        $formatted = (string) Rut::parse('168943652')->format()->hyphened()->dotted()->obfuscated();
        self::assertSame('**.***.365-2', $formatted);
    }
}
