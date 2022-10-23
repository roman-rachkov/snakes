export interface Room {
    id: number,
    playerName: string,
    max_level: string,
    min_level: string,
    bid: number,
    mode: string,
    current_players: number,
    max_players: number,
    status: string,
    next_turn: string
}
