<?php

namespace Tests\Unit;

use Tests\TestCase;

class SanitizeEmailHtmlTest extends TestCase
{
    public function test_it_strips_dangerous_attributes_from_allowed_tags(): void
    {
        $dirty = '<a href="javascript:alert(1)" onclick="alert(1)">Click</a><img src=x onerror=alert(1)>';

        $clean = sanitizeEmailHtml($dirty);

        $this->assertStringNotContainsString('javascript:', $clean);
        $this->assertStringNotContainsString('onclick', $clean);
        $this->assertStringNotContainsString('onerror', $clean);
    }
}
