<?php

namespace Tests\Unit;

use App\Contexts\Book\Application\BookService;
use App\Contexts\Book\Application\Exception\BookPriceValidationException;
use App\Contexts\Book\Domain\Contracts\BookMapperContract;
use App\Contexts\Book\Domain\Contracts\BookRepositoryContract;
use App\Contexts\Book\Domain\Entities\BookEntity;
use App\Contexts\Book\Infrastructure\Eloquent\BookModel;

use Mockery;
use Tests\TestCase;

class BookServiceTest extends TestCase
{
    public function test_create_book_with_valid_price()
    {
        $repoMock = Mockery::mock(BookRepositoryContract::class);
        $mapperMock = Mockery::mock(BookMapperContract::class);
        $bookEntity = new BookEntity(
            'Title',
            'Publisher',
            'Author',
            'Fiction',
            '2024-01-01',
            100,
            99.99
        );

        $bookModel = Mockery::mock(BookModel::class);

        $mapperMock->shouldReceive('entityToModel')
            ->once()
            ->with($bookEntity)
            ->andReturn([
                'title' => 'Title',
                'publisher' => 'Publisher',
                'author' => 'Author',
                'genre' => 'Fiction',
                'publication_date' => '2024-01-01',
                'pages' => 100,
                'price' => 99.99,
            ]);

        $repoMock->shouldReceive('create')
            ->once()
            ->with([
                'title' => 'Title',
                'publisher' => 'Publisher',
                'author' => 'Author',
                'genre' => 'Fiction',
                'publication_date' => '2024-01-01',
                'pages' => 100,
                'price' => 99.99,
            ])
            ->andReturn($bookModel);

        $mapperMock->shouldReceive('modelToEntity')
            ->once()
            ->with($bookModel)
            ->andReturn($bookEntity);

        $service = new BookService($repoMock, $mapperMock);

        $created = $service->createBook($bookEntity);

        $this->assertSame($bookEntity, $created);
    }

    public function test_create_book_with_invalid_price_throws_exception()
    {
        $this->expectException(BookPriceValidationException::class);
        $this->expectExceptionMessage('error.book.price_invalid');

        $repoMock = Mockery::mock(BookRepositoryContract::class);
        $mapperMock = Mockery::mock(BookMapperContract::class);
        $service = new BookService($repoMock, $mapperMock);

        $bookEntity = new BookEntity(
            'Title',
            'Publisher',
            'Author',
            'Fiction',
            '2024-01-01',
            100,
            99999999
        );
        $service->createBook($bookEntity);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
