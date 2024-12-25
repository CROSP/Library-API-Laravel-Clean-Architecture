<?php

namespace App\Contexts\Book\Domain\Entities;

class BookEntity implements \JsonSerializable
{
    private int $id;
    private string $title;
    private string $publisher;
    private string $author;
    private string $genre;
    private string $publicationDate;
    private int $pages;
    private float $price;

    public function __construct(
        string $title,
        string $publisher,
        string $author,
        string $genre,
        string $publicationDate,
        int    $pages,
        float  $price,
        int    $id = 0
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->publisher = $publisher;
        $this->author = $author;
        $this->genre = $genre;
        $this->publicationDate = $publicationDate;
        $this->pages = $pages;
        $this->price = $price;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    public function getPublicationDate(): string
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(string $publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function setPages(int $pages): void
    {
        $this->pages = $pages;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'publisher' => $this->getPublisher(),
            'author' => $this->getAuthor(),
            'genre' => $this->getGenre(),
            'publication_date' => $this->getPublicationDate(),
            'pages' => $this->getPages(),
            'price' => $this->getPrice(),
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
