import time
import random

class Player:
    def __init__(self, name, health, attack, defense):
        self.name = name
        self.health = health
        self.attack = attack
        self.defense = defense

    def is_alive(self):
        return self.health > 0

class Enemy:
    def __init__(self, name, health, attack, defense):
        self.name = name
        self.health = health
        self.attack = attack
        self.defense = defense

    def is_alive(self):
        return self.health > 0

def attack(attacker, target):
    damage = max(0, attacker.attack - target.defense)
    target.health -= damage
    return damage

def battle(player, enemy):
    print(f"{player.name} vs {enemy.name} - 전투 시작!")

    while player.is_alive() and enemy.is_alive():
        print(f"{player.name}: {player.health}HP, {enemy.name}: {enemy.health}HP")

        # 플레이어의 공격
        player_damage = attack(player, enemy)
        print(f"{player.name}이 {enemy.name}을(를) 공격하여 {player_damage}의 피해를 입혔습니다.")

        # 적의 공격
        enemy_damage = attack(enemy, player)
        print(f"{enemy.name}이 {player.name}에게 {enemy_damage}의 피해를 입혔습니다.")

        time.sleep(1)

    if player.is_alive():
        print(f"{player.name}이(가) {enemy.name}을(를) 이기고 전투에서 승리했습니다!")
    else:
        print(f"{player.name}이(가) 전투에서 패배했습니다.")

if __name__ == "__main__":
    player_name = input("캐릭터의 이름을 입력하세요: ")
    player = Player(name=player_name, health=100, attack=20, defense=10)

    enemy_list = [
        Enemy(name="고블린", health=30, attack=10, defense=5),
        Enemy(name="오크", health=50, attack=15, defense=8),
        Enemy(name="드래곤", health=100, attack=25, defense=15)
    ]

    while True:
        selected_enemy = random.choice(enemy_list)
        print(f"\n새로운 적이 나타났습니다: {selected_enemy.name}\n")

        input("아무 키나 눌러서 전투를 시작하세요...")
        battle(player, selected_enemy)

        play_again = input("새로운 전투를 시작하시겠습니까? (y/n): ")
        if play_again.lower() != 'y':
            print("게임을 종료합니다. 다음에 또 만나요!")
            break
