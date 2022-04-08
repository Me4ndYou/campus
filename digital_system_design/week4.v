//Code based on the simplified logic gates from answer 4c 


//Making AND Gate object
module And (x, y, F); 
    input x, y;
    output F;
endmodule

//Making Or Gate object
module Or (x, y, z, F);
    input x, y, z;
    output F;
endmodule

//The whole circuit which include 3 AND gate and 1 OR gate
module FullCircuit (a, b, c, f);
    input a,b,c;
    output f;
    wire n1, n2, n3; //for each and gate output
    And And_1(a, c, n1);
    And And_2(b, c, n2);
    And And_3(a, b, n3);
    Or Or_1(n1, n2, n3, f);
endmodule