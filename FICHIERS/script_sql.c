#include <stdio.h>
#include <stdlib.h>
#include <wchar.h>
#include <locale.h>
#include <string.h>

void decoupe(int offset,char *chaine) {
	char copie[100];
	if(strlen(chaine) > 0) {
		int i;
		int n = strlen(chaine);
		
		for(i = 0; i < n-offset; i++) {
			chaine[i] = chaine[i+offset+1];
		}
		chaine[n-offset] = '\0';
		if(chaine[0] == ';') {
			strcpy(copie,chaine);
			sprintf(chaine, " ");
			strcat(chaine,copie);
		}
	}
}

int main(void) {
	setlocale(LC_ALL,"fr_FR.UTF-8");
	
	FILE *lecture = NULL;
	FILE *ecriture = NULL;
	
	char ligne[100];
	char mot[100];
	char rq[100];
	char interm[100];
	char *ptr = NULL;
	
	int j = 2;
	int taille = 0;
	
	lecture = fopen("dico.csv","r");
	if(lecture != NULL) {
		ecriture = fopen("script.sql","w");
		while(fgets(ligne, 100, lecture)) {
			sprintf(rq,"INSERT INTO lexique VALUES (");
			j = 2;
			strcpy(mot,ligne);
			ptr = strtok(mot,";");
			sprintf(interm,"'%s'",mot);
			strcat(rq,interm);
			while(j <= 4) {
				strcat(rq,",");
				taille = strlen(mot);
				decoupe(taille,ligne);
				strcpy(mot,ligne);
				ptr = strtok(mot,";");
				sprintf(interm,"'%s'",mot);
				strcat(rq,interm);
				if(j==4)
					strcat(rq,");");
				j++;
			}
			fprintf(ecriture,"%s\n",rq);
		}
		fclose(ecriture);
		fclose(lecture);
	}
	else
		printf("Lol ça marche pas\n\n");

	return 0;
}
