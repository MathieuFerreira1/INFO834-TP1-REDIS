import redis

# Connexion à Redis
redis_client = redis.StrictRedis(host='localhost', port=6379, db=0)

# Fonction pour vérifier si l'utilisateur est autorisé à se connecter
def verifier_autorisation_utilisateur(utilisateur_id):
    # Vérifier si l'utilisateur est enregistré dans Redis
    if redis_client.exists(utilisateur_id):
        # Vérifier le nombre de connexions récentes de l'utilisateur
        nb_connexions_recentes = int(redis_client.get(utilisateur_id))
        # Vérifier si l'utilisateur a dépassé le nombre maximal de connexions
        if nb_connexions_recentes >= 10:
            return False
    # Si l'utilisateur n'est pas enregistré ou n'a pas dépassé le nombre maximal de connexions
    return True

# Fonction pour enregistrer une connexion d'utilisateur
def enregistrer_connexion_utilisateur(utilisateur_id):
    # Incrémenter le nombre de connexions de l'utilisateur dans Redis
    redis_client.incr(utilisateur_id)

# Exemple d'utilisation :
if __name__ == "__main__":
    utilisateur_id = input("Entrez l'identifiant de l'utilisateur : ")
    if verifier_autorisation_utilisateur(utilisateur_id):
        print("L'utilisateur est autorisé à se connecter.")
        enregistrer_connexion_utilisateur(utilisateur_id)
    else:
        print("L'utilisateur a dépassé le nombre maximal de connexions.")
