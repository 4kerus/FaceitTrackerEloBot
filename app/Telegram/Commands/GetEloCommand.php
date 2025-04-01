<?php

namespace App\Telegram\Commands;

use App\Services\FaceitService;
use JsonException;
use Telegram\Bot\Commands\Command;

class GetEloCommand extends Command
{
    protected string $name = 'elo';

    protected FaceitService $eloService;

    public function __construct(FaceitService $eloService)
    {
        $this->eloService = $eloService;
    }

    /**
     * @inheritDoc
     */
    public function handle(): void
    {
        $message = $this->getUpdate()->getMessage()->getText();
        $nickname = explode(' ', $message)[1] ?? null;

        if (empty($nickname)) {
            $this->replyWithMessage([
                'text' => "Please provide a nickname. /elo <nickname>",
            ]);

            return;
        }

        $data = $this->eloService->getCurrentElo($nickname);

        if ($data === null) {
            $this->replyWithMessage([
                'text' => "Nickname not found or no elo data available.",
            ]);

            return;
        }

        $lvl = $data["lvl"];
        $elo = $data["elo"];

        $this->replyWithMessage([
            'text' => "$nickname - $lvl lvl $elo elo",
//            'reply_markup' => $this->buildKeyboard(),
        ]);
    }

    /**
     * @throws JsonException
     */
    private function buildKeyboard(): false|string
    {
        return json_encode([
            'inline_keyboard' => [
                [
                    ['text' => 'Test 1', 'callback_data' => 'test_btn 1'],
                    ['text' => 'Test 2', 'callback_data' => 'test_btn 2'],
                    ['text' => 'Test 3', 'callback_data' => 'test_btn 3'],
                ],
                [
                    ['text' => '🎲 Random Number', 'callback_data' => 'random_number']
                ],
                [
                    ['text' => '🎲 Inline Keyboard', 'callback_data' => 'inline_kbd']
                ],
                [
                    ['text' => 'Void', 'callback_data' => 'void']
                ],
            ]
        ], JSON_THROW_ON_ERROR);
    }
}
