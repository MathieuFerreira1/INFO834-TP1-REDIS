import sys
import time
import redis

# Créer une connexion au serveur Redis
r = redis.Redis(host='localhost', port=6379, db=0)

def can_login(user_id):
    # Obtenir le timestamp actuel
    now = time.time()

    # Récupérer toutes les connexions de l'utilisateur
    connections = r.lrange(user_id, 0, -1)

    # Initialiser une nouvelle liste vide
    recent_connections = []

    # Parcourir chaque 'conn' dans 'connections'
    for conn in connections:
        # Convertir 'conn' en flottant et soustraire le résultat de 'now' pour obtenir la différence de temps
        time_difference = now - float(conn)

        # Vérifier si le résultat est inférieur ou égal à 600, ce qui signifie que la connexion a été effectuée dans les 10 dernières minutes
        if time_difference <= 600:
            # Si la condition est vraie, ajouter 'conn' à 'recent_connections'
            recent_connections.append(conn)

    # Vérifier si 'recent_connections' est inférieur à 10
    if len(recent_connections) < 10:
        # L'utilisateur peut se connecter
        return 1
    else:
        return 0

def attempt_login(user_id):
    # Vérifier si l'utilisateur peut se connecter
    can_login_message = can_login(user_id)
    # print(can_login_message)

    if can_login_message == 1:
        # Ajoutez le timestamp actuel à la liste de l'utilisateur
        r.lpush(user_id, time.time())
    return can_login_message

def reset_all_connections(user_ids):
    # Parcourir chaque 'user_id' dans 'user_ids' et supprimer la liste correspondante
    for user_id in user_ids:
        r.delete(user_id)

if __name__ == "__main__":
    # récupérer l'identifiant de l'utilisateur à partir des arguments de la ligne de commande
    user_id = sys.argv[1]

    # regarder si l'utilisateur peut se connecter
    print(attempt_login(user_id))