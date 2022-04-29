#include<iostream>
#include<conio.h> //kbhit()
#include<dos.h>
#include<stdlib.h>
#include<string.h>
#include <windows.h>
#include <time.h>

#define SCREEN_WIDTH 90
#define SCREEN_HEIGHT 26
#define WIN_WIDTH 70
#define MENU_WIDTH 20
#define GAP_SIZE 7
#define PIPE_DIF 45

using namespace std;

HANDLE console = GetStdHandle(STD_OUTPUT_HANDLE);
COORD CursorPosition;

int pipePosition[3];
int gapPosition[3];
int pipe[3];
char bird[3][6] = { ' ','-','-','-',' ',' ',
                    '/',' ',' ','o','\\',' ',
					'|','_','_','_',' ','>' };
int birdPosition = 6;
int score = 0;

void gotoxy(int x, int y){
    //for controlling every position
	CursorPosition.X = x;
	CursorPosition.Y = y;
	SetConsoleCursorPosition(console, CursorPosition);
}

void setcursor(bool visible, DWORD size){
	if(size == 0){
        size = 20;
	}

	CONSOLE_CURSOR_INFO lpCursor;
	lpCursor.bVisible = visible;
	lpCursor.dwSize = size;
	SetConsoleCursorInfo(console,&lpCursor);
}

void drawBorder(){

	for(int i=0; i<SCREEN_WIDTH; i++){
        //Drawing the top and bottom border of window 
		gotoxy(i,0); cout<<"-";
		gotoxy(i,SCREEN_HEIGHT); cout<<"-";
	}

	for(int i=0; i<SCREEN_HEIGHT; i++){
        //Drawing the left and right border of window 
		gotoxy(0,i); cout<<"|";
		gotoxy(SCREEN_WIDTH,i); cout<<"|";
	}
	for(int i=0; i<SCREEN_HEIGHT; i++){
        //Drawing left border for menu
		gotoxy(WIN_WIDTH,i); cout<<"|";
	}
}

class Pipe{
public:
    void generatePipe(int ind){
        gapPosition[ind] = 3 + rand()%14; //To change the variety of gap position
    }
    void drawPipe(int ind){
        if( pipe[ind] == true ){
            for(int i=0; i<gapPosition[ind]; i++){ //for drawing top pipe
                gotoxy(WIN_WIDTH-pipePosition[ind],i+1); cout<<"###";
            }
            for(int i=gapPosition[ind]+GAP_SIZE; i<SCREEN_HEIGHT-1; i++){ //for drawing bottom pipe
                gotoxy(WIN_WIDTH-pipePosition[ind],i+1); cout<<"###";
            }
        }
    }
    void erasePipe(int ind){
        if( pipe[ind] == true ){
            for(int i=0; i<gapPosition[ind]; i++){
                gotoxy(WIN_WIDTH-pipePosition[ind],i+1); cout<<"   ";
            }
            for(int i=gapPosition[ind]+GAP_SIZE; i<SCREEN_HEIGHT-1; i++){
                gotoxy(WIN_WIDTH-pipePosition[ind],i+1); cout<<"   ";
            }
        }
    }
};

class Bird{
public:
    void drawBird(){
        for(int i=0; i<3; i++){
            for(int j=0; j<6; j++){
                gotoxy(j+3,i+birdPosition);
                cout<<bird[i][j];
            }
        }
    }
    void eraseBird(){
        for(int i=0; i<3; i++){
            for(int j=0; j<6; j++){
                gotoxy(j+3,i+birdPosition); cout<<" ";
            }
        }
    }
};

int collision(){
	if( pipePosition[0] >= 61  ){
		if( birdPosition<gapPosition[0] || birdPosition>gapPosition[0]+GAP_SIZE ){
			return 1;
		}
	}
	return 0;
}
void debug(){
    //gotoxy(SCREEN_WIDTH + 3, 4); cout<<"Pipe Pos: "<<pipePosition[0];
}
void gameover(){
	system("cls");
	cout<<endl;
	cout<<"\t\t--------------------------"<<endl;
	cout<<"\t\t-------- Game Over -------"<<endl;
	cout<<"\t\t--------------------------"<<endl<<endl;
	cout<<"\t\t--------------------------"<<endl;
	cout<<"\t\t-------- Your Score ------"<<endl;
	cout<<"\t\t--------     "<<score<<"       ------"<<endl;
	cout<<"\t\t--------------------------"<<endl<<endl;
	cout<<"\t\tPress any key to go back to menu.";
	getch();
}
void updateScore(){
	gotoxy(WIN_WIDTH + 7, 5);
	 cout<<"Score: "<<score<<endl;
}

void instructions(){
	system("cls");
	cout<<"Instructions";
	cout<<"\n----------------"<<endl;
	cout<<"\n Press 'spacebar' to make bird fly";
	cout<<"\n Release 'spacebar' to make bird go down";
	cout<<"\n\nPress any key to go back to menu";
	getch();
}

void play(){
	birdPosition = 6;
	score = 0;
	pipe[0] = 1;
	pipe[1] = 0;
	pipePosition[0] = pipePosition[1] = 4;

    Pipe playPipe;//making pipe

	system("cls");
	drawBorder();
	playPipe.generatePipe(0);
	updateScore();

	gotoxy(WIN_WIDTH + 5, 2);cout<<"FLAPPY BIRD";
	gotoxy(WIN_WIDTH + 6, 4);cout<<"----------";
	gotoxy(WIN_WIDTH + 6, 6);cout<<"----------";
	gotoxy(WIN_WIDTH + 7, 12);cout<<"Control ";
	gotoxy(WIN_WIDTH + 7, 13);cout<<"-------- ";
	gotoxy(WIN_WIDTH + 2, 14);cout<<" Spacebar = Jump";
    gotoxy(WIN_WIDTH + 2, 20);cout<<" Press ESC to ";
    gotoxy(WIN_WIDTH + 2, 21);cout<<" leave the game";

	gotoxy(10, 13);cout<<"Press any key to start";
	getch();
	gotoxy(10, 13);cout<<"          3           ";
	Sleep(1000);
	gotoxy(10, 13);cout<<"          2           ";
	Sleep(1000);
	gotoxy(10, 13);cout<<"          1           ";
	Sleep(1000);
	gotoxy(10, 13);cout<<"have fun~             ";

	while(1){
		if(kbhit()){ //Determine if a key has been pressed or not
			char ch = getch();
			if(ch==32){ //SPACE button to fly
				if( birdPosition > 3 )
					birdPosition-=3;
			}
			if(ch==27){ //ESC button to abort current session
				break;
			}
		}
        
        Bird playBird; //making bird
		playBird.drawBird();
		playPipe.drawPipe(0);
		playPipe.drawPipe(1);
		debug();
		if( collision() == 1 ){
			gameover();
			return;
		}
		Sleep(100);//Determine how long the bird is flying
		playBird.eraseBird();
		playPipe.erasePipe(0);
		playPipe.erasePipe(1);
		birdPosition += 1;

		if( birdPosition > SCREEN_HEIGHT - 3 ){ //If bird hit the ground
			gameover();
			return;
		}

		if( pipe[0] == 1 ){
            pipePosition[0] += 2;
		}


		if( pipe[1] == 1 ){
            pipePosition[1] += 2;
		}

		if( pipePosition[0] >= 40 && pipePosition[0] < 42 ){//when to generate a new pipe
			pipe[1] = 1;
			pipePosition[1] = 4;
			playPipe.generatePipe(1);
		}
		if( pipePosition[0] > 68 ){ //if bird succesfully pass the pipe
			score++;
			updateScore();
			pipe[1] = 0;
			pipePosition[0] = pipePosition[1];
			gapPosition[0] = gapPosition[1];
		}
	}
}

int main()
{
	setcursor(0,0);
	srand( (unsigned)time(NULL));

	do{
		system("cls");
		gotoxy(10,5); cout<<" -------------------------- ";
		gotoxy(10,6); cout<<" |      Flappy Bird       | ";
		gotoxy(10,7); cout<<" --------------------------";
		gotoxy(10,9); cout<<"1. Start Game";
		gotoxy(10,10); cout<<"2. Instructions";
		gotoxy(10,11); cout<<"3. Quit";
		gotoxy(10,13); cout<<"Select option: ";
		char op = getche();

		if( op=='1'){
		    play();
		}
		else if( op=='2'){
            instructions();
		}
		else if( op=='3'){
            exit(0);
		}

	}while(1);

	return 0;
}
