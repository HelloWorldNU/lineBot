<?php

namespace Firebase;

use Firebase\Database\ApiClient;
use Firebase\Database\Reference;
use Firebase\Exception\InvalidArgumentException;
use Firebase\Exception\OutOfRangeException;
use Firebase\Http\Auth;
use GuzzleHttp\Psr7;
use Psr\Http\Message\UriInterface;

/**
 * The Firebase Realtime Database.
 *
 * @see https://firebase.google.com/docs/reference/js/firebase.database.Database
 */
class Database
{
    /**
     * @var ApiClient
     */
    private $client;

    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * Creates a new database instance for the given database URI
     * which is accessed by the given API client.
     *
     * @param UriInterface $uri
     * @param ApiClient $client
     */
    public function __construct(UriInterface $uri, ApiClient $client)
    {
        $this->uri = $uri;
        $this->client = $client;
    }

    /**
     * Returns a new Database instance with the given authentication override.
     *
     * @param Auth $auth
     *
     * @return Database
     */
    public function withCustomAuth(Auth $auth): Database
    {
        return new self($this->uri, $this->client->withCustomAuth($auth));
    }

    /**
     * Returns a Reference to the root or the specified path.
     *
     * @see https://firebase.google.com/docs/reference/js/firebase.database.Database#ref
     *
     * @param string $path
     *
     * @return Reference
     */
    public function getReference(string $path = ''): Reference
    {
        return new Reference($this->uri->withPath($path), $this->client);
    }

    /**
     * Returns a reference to the root or the path specified in url.
     *
     * @see https://firebase.google.com/docs/reference/js/firebase.database.Database#refFromURL
     *
     * @param string|UriInterface $uri
     *
     * @throws InvalidArgumentException If the URL is invalid
     * @throws OutOfRangeException If the URL is not in the same domain as the current database
     *
     * @return Reference
     */
    public function getReferenceFromUrl($uri): Reference
    {
        try {
            $uri = Psr7\uri_for($uri);
        } catch (\InvalidArgumentException $e) {
            // Wrap exception so that everything stays inside the Firebase namespace
            throw new InvalidArgumentException($e->getMessage(), $e->getCode());
        }

        if ($givenHost = $uri->getHost() !== $dbHost = $this->uri->getHost()) {
            throw new InvalidArgumentException(sprintf(
                'The given URI\'s host "%s" is not covered by the database for the host "%s".',
                $givenHost, $dbHost
            ));
        }

        return new Reference($this->uri->withPath($uri->getPath()), $this->client);
    }
}
