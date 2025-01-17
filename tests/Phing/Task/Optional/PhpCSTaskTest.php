<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */

namespace Phing\Test\Task\Optional;

use Phing\Exception\BuildException;
use Phing\Test\Support\BuildFileTest;

/**
 * Tests for PhpCSTask.
 *
 * @author Siad Ardroumli <siad.ardroumli@gmail.com>
 *
 * @internal
 */
class PhpCSTaskTest extends BuildFileTest
{
    public function setUp(): void
    {
        if (class_exists('PHP_CodeSniffer')) {
            $this->markTestSkipped('PHP CodeSniffer 2 package available.');
        }
        $this->configureProject(PHING_TEST_BASE . '/etc/tasks/ext/phpcs/build.xml');
    }

    public function testPhpCs(): void
    {
        $this->executeTarget(__FUNCTION__);
        $this->assertInLogs('Missing');
    }

    public function testMissingFileSetAndFilePhpCs1(): void
    {
        $this->expectException(BuildException::class);
        $this->executeTarget(__FUNCTION__);
    }

    public function testFileSetInPhpCs1(): void
    {
        $this->expectNotToPerformAssertions();
        $this->executeTarget(__FUNCTION__);
    }

    public function testFileSetInPhpCs1OutfileSet(): void
    {
        $this->executeTarget(__FUNCTION__);
        $this->assertInLogs('Outfile set to /dev/null');
    }

    public function testFileSetInPhpCs1FormatSet(): void
    {
        $this->executeTarget(__FUNCTION__);
        $this->assertInLogs('Format set to checkstyle');
    }

    public function testMultipleReportFormattersSet(): void
    {
        $this->executeTarget(__FUNCTION__);
        $this->assertInLogs('Generate report of type "checkstyle" with report written to /tmp/null1');
        $this->assertInLogs('Generate report of type "summary" with report written to /tmp/null2');
    }
}
