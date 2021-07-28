#%%
from typing import Pattern
import nltk, random
from nltk import featstruct
from nltk.util import pr
import pandas as pd
import numpy as np
import sklearn
from nltk.corpus import stopwords
nltk.download('punkt')
nltk.download('averaged_perceptron_tagger')
from nltk import word_tokenize

pattern = r'''(?x)                 # set flag to allow verbose regexps
              (?:[A-Z]\.)+         # abbreviations, e.g. U.S.A.
              | \w+(?:-\w+)*       # words with optional internal hyphens
              | \$?\d+(?:\.\d+)?%? # currency and percentages, e.g. $12.40, 82%
              | \.\.\.             # ellipsis
              | [][.,;"'?():-_`]   # these are separate tokens; includes ], [
'''

df = pd.read_csv('C:\\Users\\alexa\\OneDrive\\Desktop\\Insultos para BOT CSV 3.csv', names = ['clase','contenido'])
df['tokens'] = df['contenido'].apply(lambda x:nltk.regexp_tokenize(x,pattern))
#DATA set de insultos
df_Insulto= df[df["clase"]==-1]
# Quito palabras inutiles
stop_words= set(stopwords.words('spanish'))

stop_words2 = ["si",".","de","el","que","a","como","una","que","mas","Como","¿Por qué?","esta","es","tan","Que","Soy","ver"]
Palabras_Insulto = nltk.FreqDist([w for tokenlist in df_Insulto['tokens'].values for w in tokenlist]) 


Palabras = nltk.FreqDist([w for tokenlist in df['tokens'].values for w in tokenlist if w not in stop_words and w not in stop_words2]) 
Top_Palabras = Palabras.most_common(200)
Top_Palabras_insulto = Palabras_Insulto.most_common(200)

Lista_palabras = [w for (w) in Palabras]

Lista_palabras_Insulto = [w for (w,c) in Top_Palabras_insulto]
print(df['clase'].hist())


#bigram_text = nltk.Text([w for token in Lista_palabras for w in token])
#igrams = list(nltk.bigrams(bigram_text))
#top_bigrams = (nltk.FreqDist(bigrams)).most_common(250)




def document_features(document):
    document_words = set(document)
    features = {}
    features['longitud'] = len(document)
    for word,i in Top_Palabras:
        features['contains({})'.format(word)] = (word in document_words)
       
    return features

# Separamos en las listas en train y test
fset = [(document_features(texto), clase) for texto, clase in zip(df['tokens'].values, df['clase'].values)]
random.shuffle(fset)
print(len(fset))
train, test = fset[:120], fset[60:]

Texto= input()


lista= ["todo","bien"]

classifier = nltk.NaiveBayesClassifier.train(train)
print(nltk.classify.accuracy(classifier, test))

print(classifier.classify(document_features(lista)))
#print (classifier.show_most_informative_features(50))
