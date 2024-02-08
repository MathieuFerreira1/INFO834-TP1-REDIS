import sys
import time
import redis

# Créer une connexion au serveur Redis
r = redis.Redis(host='localhost', port=6379, db=0)

def can_login(user_id):
    # Obtenez le timestamp actuel
    now = time.time()

    # Récupérez toutes les connexions de l'utilisateur
    connections = r.lrange(user_id, 0, -1)

    # Initialiser une nouvelle liste vide
    recent_connections = []

    # Parcourir chaque 'conn' dans 'connections'
    for conn in connections:
        # Convertir 'conn' en flottant et soustraire le résultat de 'now'
        time_difference = now - float(conn)

        # Vérifier si le résultat est inférieur ou égal à 600
        if time_difference <= 600:
            # Si la condition est vraie, ajouter 'conn' à 'recent_connections'
            recent_connections.append(conn)

    if len(recent_connections) < 10:
        # L'utilisateur peut se connecter
        return "La connexion est possible."
    else:
        return "La connexion est impossible, vous vous êtes connecté plus de 10 fois dans les 10 dernières minutes."

def attempt_login(user_id):
    can_login_message = can_login(user_id)
    print(can_login_message)

    if "possible" in can_login_message:
        # Ajoutez le timestamp actuel à la liste de l'utilisateur
        r.lpush(user_id, time.time())
        return True
    else:
        return False

def reset_all_connections(user_ids):
    for user_id in user_ids:
        r.delete(user_id)

if __name__ == "__main__":
    # Liste des identifiants des utilisateurs
    user_id = sys.argv[1]
    attempt_login(user_id)