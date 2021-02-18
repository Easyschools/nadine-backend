<?php


namespace App\ThirdParty;


use GuzzleHttp\Client;

class SmsMasr
{

    /**
     * @var string
     */
    private $url = 'https://smsmisr.com/api/webapi';
    /**
     * @var string
     */
    private $username = 'ZnyOBzTn';
    /**
     * @var string
     */
    private $password = 'KqAbdu3r1l';
    /**
     * @var string
     */
    private $sender = 'Maintenance';
    /**
     * @var string
     */
    private $message;
    /**
     * @var string
     */
    private $numbers;
    /**
     * @var int
     */
    private $lang = 2;

    /**
     * SMSMisrService constructor.
     * @param string $message
     * @param array $numbers
     * @param int $lang
     */
    public function __construct(string $message, array $numbers, int $lang = 2)
    {
        $this->setMessage($message);
        $this->setNumbers($numbers);
        $this->setLang($lang);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getNumbers(): string
    {
        return $this->numbers;
    }

    /**
     * @return int
     */
    public function getLang(): int
    {
        return $this->lang;
    }

    /**
     * @param int $lang
     */
    public function setLang(int $lang): void
    {
        if (in_array($lang, [1, 2, 3])) {
            $this->lang = $lang;
        }
    }

    /**
     * @param array $numbers
     */
    public function setNumbers(array $numbers): void
    {
        $this->numbers = implode(',', $numbers);
    }

    /**
     * @return string
     */
    public function sendMessage()
    {
//        dd(get_object_vars($this));
        $client = new Client();
        $response = $client->post($this->url, [
            'query' => [
                'username' => $this->username,
                'password' => $this->password,
                'message' => $this->message,
                'language' => $this->lang,
                'sender' => $this->sender,
                'mobile' => $this->numbers,
            ]
        ]);
        $body = $response->getBody();
        return $body->getContents();
    }
}
