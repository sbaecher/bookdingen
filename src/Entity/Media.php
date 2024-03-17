<?php

class Media
{
    private string $id;
    private string $title;
    private string $author;
    private string $mediaCode;
    private string $category;
    private string $description;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getMediaCode(): string
    {
        return $this->mediaCode;
    }

    /**
     * @param string $mediaCode
     */
    public function setMediaCode(string $mediaCode): void
    {
        $this->mediaCode = $mediaCode;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'author' => $this->getAuthor(),
            'title' => $this->getTitle(),
            'category' => $this->getCategory(),
            'mediaCode' => $this->getMediaCode(),
            'description' => $this->getDescription(),
        ];
    }
}