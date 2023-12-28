import sqlite3

# SQLite 데이터베이스 연결
conn = sqlite3.connect('monsters.db')
cursor = conn.cursor()

# 몬스터 테이블 생성
cursor.execute('''
    CREATE TABLE IF NOT EXISTS monsters (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        health INTEGER NOT NULL,
        attack INTEGER NOT NULL,
        defense INTEGER NOT NULL
    )
''')
conn.commit()

class Monster:
    def __init__(self, name, health, attack, defense):
        self.name = name
        self.health = health
        self.attack = attack
        self.defense = defense

    def save_to_db(self):
        # 새로운 몬스터를 데이터베이스에 추가
        cursor.execute('''
            INSERT INTO monsters (name, health, attack, defense)
            VALUES (?, ?, ?, ?)
        ''', (self.name, self.health, self.attack, self.defense))
        conn.commit()

def load_monsters_from_db():
    # 데이터베이스에서 모든 몬스터를 가져와 리스트로 반환
    cursor.execute('SELECT * FROM monsters')
    rows = cursor.fetchall()
    monsters = []
    for row in rows:
        monsters.append(Monster(name=row[1], health=row[2], attack=row[3], defense=row[4]))
    return monsters

# 몬스터 데이터베이스에 추가 예시
monster1 = Monster(name='고블린', health=30, attack=10, defense=5)
monster2 = Monster(name='오크', health=50, attack=15, defense=8)

monster1.save_to_db()
monster2.save_to_db()

# 몬스터 데이터베이스에서 불러오기 예시
loaded_monsters = load_monsters_from_db()
for monster in loaded_monsters:
    print(f"Loaded Monster: {monster.name}, Health: {monster.health}, Attack: {monster.attack}, Defense: {monster.defense}")

# 데이터베이스 연결 닫기
conn.close()
