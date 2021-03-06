#!/bin/bash

listurl=https://sourceforge.net/projects/opengoo/files/fengoffice/
baseurl=https://downloads.sourceforge.net/project/opengoo/fengoffice/
mirror=deac-riga
file=fengoffice_
ext=.zip
openapp=unzip

git init
git add init.sh
git commit -m "initial magical version"

mkdir $file

versionlist=$(curl "$listurl" | grep "<span class=\"name\">" | striptags | tr $'\n' , | tr -d "[:space:]")
echo Versions: $versionlist


for version in $(echo "$versionlist" | tr , $'\n' |tac ); do 
 echo Downloading version $version
 mkdir -p versions/$version/
 mkdir -p versionfiles
 echo "$baseurl/$version/$version$ext?r=&ts=$(date +%s)&user_mirror=$mirror"
 curl -L -C- "$baseurl/$version/$version$ext?r=&ts=$(date +%s)&user_mirror=$mirror" -o versionfiles/$version$ext
 unzip -o versionfiles/$version$ext -d versions/$version/
 od="$(ls -1 versions/$version/)"
 f=$(echo $od | wc -l )
 if [ "$f" == "1" ]; then
  mv -f versions/$version/$od/{.,}* versions/$version/
  rmdir versions/$version/$od
 fi
 cp -af versions/$version/.* $file/
 git add $file/
 git commit -m "$version"
done
