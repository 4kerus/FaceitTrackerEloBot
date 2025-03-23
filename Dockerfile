FROM golang:1.24 AS builder

WORKDIR /app

COPY go.mod go.sum ./
RUN go mod tidy

COPY . .

RUN go build -o faceit-bot main.go

FROM debian:latest

WORKDIR /app

RUN apt-get update && apt-get install -y ca-certificates && rm -rf /var/lib/apt/lists/*

COPY --from=builder /app/faceit-bot /app/faceit-bot

RUN chmod +x /app/faceit-bot

CMD ["/app/faceit-bot"]