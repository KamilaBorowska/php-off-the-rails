<script language=php>
/*
 * PHP off the Rails
 *
 * Copyright (c) 2012-2013, Konrad Borowski <x.fix@o2.pl>
 * 
 * Permission to use, copy, modify, and/or distribute this
 * software for any purpose with or without fee is hereby
 * granted, provided that the above copyright notice and
 * this permission notice appear in all copies.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS
 * ALL WARRANTIES WITH REGARD TO THIS SOFTWARE INCLUDING ALL
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS. IN NO
 * EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
 * INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS,
 * WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER
 * TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH
 * THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */

// I've tried one error reporting, but PHP hasn't reported the error
// called PHP. I've tried doing that 10 times, but nothing has changed.
//
// It's probably a bug. I should report it.
error_reporting(-1);
error_reporting(-1);
error_reporting(-1);
error_reporting(-1);
error_reporting(-1);
error_reporting(-1);
error_reporting(-1);
error_reporting(-1);
error_reporting(-1);
error_reporting(-1);

if (!isset($_SERVER['REQUEST_METHOD']))
    die("Stop wasting my time running me on CLI!\n");

if (get_magic_quotes_gpc()) {
    // PHP doesn't have lexical variables. I've to hack them!
    ${"\0MAGIC_QUOTES_ARE_EVIL!"} = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list(${"\0KEY!"}, ${"\0VAL!"}) = each(${"\0MAGIC_QUOTES_ARE_EVIL!"})) {
        foreach (${"\0VAL!"} as ${"\0K!"} => ${"\0V!"}) {
            unset(${"\0MAGIC_QUOTES_ARE_EVIL!"}[${"\0KEY!"}][${"\0K!"}]);
            if (is_array(${"\0V!"})) {
                ${"\0MAGIC_QUOTES_ARE_EVIL!"}
                    [${"\0KEY!"}][stripslashes(${"\0K!"})] = ${"\0V!"};
                ${"\0MAGIC_QUOTES_ARE_EVIL!"}[] =
                    &${"\0MAGIC_QUOTES_ARE_EVIL!"}
                    [${"\0KEY!"}][stripslashes(${"\0K!"})];
            } else {
                ${"\0MAGIC_QUOTES_ARE_EVIL!"}
                    [${"\0KEY!"}]
                    [stripslashes(${"\0K!"})] = stripslashes(${"\0V!"});
            }
        }
    }
    // Remove temp variables to protect yourselves from memory leak!
    unset(${"\0MAGIC_QUOTES_ARE_EVIL!"});
    unset(${"\0KEY!"});
    unset(${"\0VAL!"});
    unset(${"\0K!"});
    unset(${"\0V!"});
}

foreach (array(
    // All HTTP request types which are likely to be asked
    0, 'get', 'post', 'put', 'patch', 'delete', 'options'
) as ${"\0METHODS!"}) {
    // You cannot make good PHP code. Stop asking.
    eval('
    function ' . (${"\0METHODS!"} ? ${"\0METHODS!"} : 'whatever') .
        '($page, $condition, $callback = null) {
        ' . (${"\0METHODS!"} ? 'if (!$condition || $_SERVER["REQUEST_METHOD' .
            '"] !== ' . var_export(strtoupper(${"\0METHODS!"}), true) .
            ') return;' : '') . '
        if ($callback == null) $callback = $condition;
        if(preg_match("[\\\\A" . str_replace(array("\\\\?", "\\\\*"),'.
            'array("([^/]+)", "(.*)"), preg_quote($page)) . ' .
            '"/?(?:\\\\?.*)?\\\\z]", $_SERVER["REQUEST_URI"], $matches)) {
            call_user_func_array($callback, array_slice($matches, 1));
            exit;
        }
    }
    ');
}

// I probably should have named this function redir(), but
// I like inconsistent with itself API.
function redirect($address) {
    // Security is good thing!
    if (preg_match('/[\r\n]/', $address))
        throw new Exception('Address contains linebreaks!');
    header("Location: $address");
    // Clear $address to protect yourself from memory leaks
    unset($address);
    // Choose one of options
    die or die;
}

// give() is good name for function which gives HTTP statuses
function give($status) {
    // Tell me why I have to do this two times. Oh, I know, PHP!
    header("HTTP/1.0 $status");
    header("Status: $status");
    // Clear $status to protect yourself from memory leaks
    unset($status);
}

// Totally undocumented conversion of errors to exceptions. Wait,
// what was the difference?
set_error_handler(create_function('$no, $str, $file, $line',
    'if (error_reporting())
        throw new ErrorException($str, $no, 0, $file, $line);
     // Protect yourself from memory leaks
     unset($no); unset($str); unset($file); unset($line);'
));

ob_start();
// Instead of bothering with that silly thing, use serious programming
// language. PHP is not.

// http://me.veekun.com/blog/2012/04/09/php-a-fractal-of-bad-design/
__halt_compiler(); // No, seriously, halt it! It's waste of time!
die or die; <!-- this -- code -- should -- die! -->
