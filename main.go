package main

import (
	"encoding/json"
	"fmt"
	"github.com/go-resty/resty/v2"
	tgbotapi "github.com/go-telegram-bot-api/telegram-bot-api/v5"
	"log"
	"net/http"
	"os"
)

const faceitAPI = "https://open.faceit.com/data/v4"

var (
	botToken    = os.Getenv("TELEGRAM_BOT_TOKEN")
	faceitToken = os.Getenv("FACEIT_API_KEY")
	client      = resty.New()
)

func main() {
	bot, err := tgbotapi.NewBotAPI(botToken)
	if err != nil {
		log.Fatal("Ошибка создания бота:", err)
	}

	bot.Debug = true
	log.Printf("Бот запущен как %s", bot.Self.UserName)

	u := tgbotapi.NewUpdate(0)
	u.Timeout = 60

	updates := bot.GetUpdatesChan(u)

	for update := range updates {
		if update.Message == nil {
			continue
		}

		cmd := update.Message.Command()
		args := update.Message.CommandArguments()

		switch cmd {
		case "start":
			msg := tgbotapi.NewMessage(update.Message.Chat.ID, "Привет! Используй /elo <ник> для проверки рейтинга.")
			bot.Send(msg)

		case "elo":
			if args == "" {
				msg := tgbotapi.NewMessage(update.Message.Chat.ID, "Укажи никнейм: /elo <ник>")
				bot.Send(msg)
				continue
			}

			elo, lvl, err := getElo(args)
			if err != nil {
				msg := tgbotapi.NewMessage(update.Message.Chat.ID, "Проверь корректность никнейма!")
				bot.Send(msg)
				continue
			}

			msg := tgbotapi.NewMessage(update.Message.Chat.ID, fmt.Sprintf("%s: %d lvl %d elo", args, lvl, elo))
			bot.Send(msg)

		}
	}
}

func getElo(nickname string) (int, int, error) {
	resp, err := client.R().
		SetHeader("Authorization", "Bearer "+faceitToken).
		SetHeader("Accept", "application/json").
		Get(fmt.Sprintf("%s/players?nickname=%s", faceitAPI, nickname))

	if err != nil {
		return 0, 0, err
	}

	fmt.Println(string(resp.Body()))

	if resp.StatusCode() != http.StatusOK {
		return 0, 0, fmt.Errorf("ошибка API: %s", resp.String())
	}

	type Player struct {
		Games struct {
			CS2 struct {
				FaceitElo int `json:"faceit_elo"`
				FaceitLVL int `json:"skill_level"`
			} `json:"cs2"`
		} `json:"games"`
	}

	var player Player
	err = json.Unmarshal(resp.Body(), &player)
	if err != nil {
		return 0, 0, err
	}

	return player.Games.CS2.FaceitElo, player.Games.CS2.FaceitLVL, nil
}
