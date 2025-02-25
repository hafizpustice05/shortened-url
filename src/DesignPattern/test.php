<?php

namespace App\Services;

use Throwable;

interface ProcessorInterface
{
    public function urlProcess(string $input): string;
}

class DoubleSlashes implements ProcessorInterface
{
    public function urlProcess(string $input): string
    {
        return preg_replace('#(?<!:)//+#', '/', $input);
    }
}


class TrimProcessor implements ProcessorInterface
{
    public function urlProcess(string $input): string
    {
        return rtrim(trim($input), '/\/$/');
    }
}

class HttpProtocolProcessor implements ProcessorInterface
{
    public function urlProcess(string $input): string
    {
        return  preg_match($input, '/^(http|https):\/\//');
    }
}
class UrlValidationService
{
    /**
     * Sotore Service class object
     * @var array
     */
    private array $processors = [];

    public function __construct(protected string $url) {}

    /**
     * Undocumented function
     *
     * @param ProcessorInterface $processor
     * @return self
     */
    public function addProcessor(ProcessorInterface $processor): self
    {
        $this->processors[] = $processor;
        return $this; // Return the current instance for method chaining
    }

    public function process(): string
    {
        foreach ($this->processors as $processor) {
            $this->url = $processor->urlProcess($this->url);
        }
        return $this->url; // Return the final processed input
    }
}


// Create an instance of UrlValidationService
$object = new UrlValidationService("https://www.html.service///hello///service///   ");

// Process the input string
$validUrl = $object
    ->addProcessor(new DoubleSlashes())
    ->addProcessor(new TrimProcessor())
    ->addProcessor(new HttpProtocolProcessor())
    ->process();

app()->bind(ProcessorInterface::class, UrlValidationService::class);
// dd($validUrl);


class Transaction
{
    public function __construct(private float $amount) {}

    public function addTax(float $rate): self
    {
        $this->amount += $this->amount * $rate / 100;
        return $this;
    }

    public function applyDiscount(float $rate): self
    {
        $this->amount -= $this->amount * $rate / 100;
        // throw new InvalidArgumentException("Error InvalidArgumentException", 1);

        return $this;
    }

    public function FunctionName(): float
    {
        return $this->amount;
    }
}


try {
    $amount = (new Transaction(100))
        ->addTax(8)
        ->applyDiscount(10);
} catch (Throwable $th) {

    $arr = [
        "line" => $th->getLine(),
        "message" => $th->getMessage(),
        "file" => $th->getFile(),
        "log" =>  __CLASS__ . ":" . __LINE__
    ];
    // dd($arr);
}


$arr = [
    "a" => "a",
    "c" => "b",
    "b" => "c",
];

$b = [1, 2, 3, ...$arr];

// $arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

if (!\in_array("a", $arr, false)) {
    // dd($b);
}
// dd($arr);